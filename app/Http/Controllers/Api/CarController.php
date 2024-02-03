<?php

namespace App\Http\Controllers\Api;

use App\DTO\Cars\CreateCarDTO;
use App\DTO\Cars\UpdateCarDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCar;
use App\Http\Resources\CarResource;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarController extends Controller
{
    public function __construct(protected CarService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cars = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 3),
            filter: $request->filter,
        );

        return (new CarResource($cars))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestCar $request)
    {
        $car = $this->service->new(
            CreateCarDTO::makeFromRequest($request)
        );

        return (new CarResource($car))
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

        return new CarResource($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestCar $request, string $id)
    {
        $car = $this->service->update(
            UpdateCarDTO::makeFromRequest($request, $id)
        );

        if (!$car) {
            return response()->json([
                'error' => 'The requested register has not been found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new CarResource($car);
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
