<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Rent\RentDTO;
use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRent;
use App\Http\Resources\RentResource;
use App\Http\Resources\UserResource;
use App\Services\RentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RentController extends Controller
{
    public function __construct(protected RentService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $idUser)
    {
        // $supports = Support::paginate();
        $rents = $this->service->paginate(
            idUser: $idUser,
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page, 3'),
            filter: $request->filter,
        );

        return (new RentResource($rents))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestRent $request)
    {
        $idUser = $request->id_user;
        $idCar  = $request->id_car;

        if ($errors = $this->service->checkUserAndCar($idUser, $idCar)) {
            return response()->json($errors, Response::HTTP_NOT_FOUND);
        }

        if ($this->service->findRentedCarByUser($idCar, $idUser)) {
            return response()->json([
                'error' => 'The requested car is already rented by user'
            ], Response::HTTP_BAD_REQUEST);
        }

        $rent = $this->service->new(
            RentDTO::makeFromRequest($request)
        );

        return (new RentResource($rent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function returnCar(RequestRent $request)
    {
        $idUser = $request->id_user;
        $idCar  = $request->id_car;

        if ($errors = $this->service->checkUserAndCar($idUser, $idCar)) {
            return response()->json($errors, Response::HTTP_NOT_FOUND);
        }

        if (!$this->service->findRentedCarByUser($idCar, $idUser)) {
            return response()->json([
                'error' => 'The requested car is not rented by user'
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->service->returnCarByUser($idCar, $idUser);

        return response()->json([
            'success' => 'The requested register has been updated'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFromCar(string $idCar)
    {
        if (!$this->service->findRentByCar($idCar)) {
            return response()->json([
                'error' => 'The requested register has not been found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->service->deleteFromCar($idCar);

        return response()->json([
            'success' => 'The requested register has been disabled'
        ], Response::HTTP_OK);
    }
}
