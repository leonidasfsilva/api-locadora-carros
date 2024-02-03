<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUser;
use App\Http\Resources\RentResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $supports = Support::paginate();
        $users = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 3),
            filter: $request->filter,
        );

        return (new UserResource($users))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestUser $request)
    {
        $user = $this->service->new(
            CreateUserDTO::makeFromRequest($request)
        );

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display details about the specified resource.
     */
    public function show(string $id)
    {
        if (!$car = $this->service->findOne($id)) {
            return response()->json([
                'error' => 'The requested register has not been found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new UserResource($car);
    }

    /**
     * Display details about the cars rental for a specific user.
     */
    public function rentsUser(string $id)
    {
        if (!$rents = $this->service->findRents($id)) {
            return response()->json([
                'error' => 'No registers found'
            ], Response::HTTP_NOT_FOUND);
        }

        return ApiAdapter::toJson($rents);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestUser $request, string $id)
    {
        $car = $this->service->update(
            UpdateUserDTO::makeFromRequest($request, $id)
        );

        if (!$car) {
            return response()->json([
                'error' => 'The requested register has not been found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new UserResource($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->service->findOne($id)) {
            return response()->json([
                'error' => 'The requested register has not been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->service->delete($id);

        return response()->json([
            'success' => 'The requested register has been disabled'
        ], Response::HTTP_OK);
    }
}
