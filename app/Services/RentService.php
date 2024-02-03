<?php

namespace App\Services;

use App\DTO\Rent\RentDTO;
use App\Models\Car;
use App\Models\User;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\RentRepositoryInterface;
use App\Repositories\Eloquent\CarEloquentORM;
use App\Repositories\Eloquent\UserEloquentORM;
use stdClass;

class RentService
{
    public function __construct(protected RentRepositoryInterface $repository)
    {
    }

    public function paginate(int $idUser, ?int $page = 1, ?int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        return $this->repository->paginate(
            idUser: $idUser,
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function getAll(string $filter = null): array
    {
        return $this->repository->getAll($filter);
    }

    public function findRentByUser(string $idUser): stdClass|null
    {
        return $this->repository->findRentByUser($idUser);
    }

    public function findRentByCar(string $idCar): stdClass|null
    {
        return $this->repository->findRentByCar($idCar);
    }

    public function findRentedCarByUser(string $idCar, string $idUser): stdClass|bool
    {
        return $this->repository->findRentedCarByUser($idCar, $idUser);
    }

    public function new(RentDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }

    public function findUser($idUser)
    {
        $userModel      = new User();
        $userRepository = new UserEloquentORM($userModel);
        $userService    = new UserService($userRepository);

        $user = $userService->findOne($idUser);

        if (!$user) {
            return false;
        }
        return true;
    }

    public function findCar($idCar)
    {
        $carModel      = new Car();
        $carRepository = new CarEloquentORM($carModel);
        $carService    = new CarService($carRepository);

        $car = $carService->findOne($idCar);

        if (!$car) {
            return false;
        }
        return true;
    }

    public function returnCarByUser(string $idCar, string $idUser): void
    {
        $this->repository->returnCarByUser($idCar, $idUser);
    }

    public function deleteFromCar(string $idCar): void
    {
        $this->repository->deleteFromCar($idCar);
    }

    public function deleteFromUser(string $idUser): void
    {
        $this->repository->deleteFromUser($idUser);
    }

    public function checkUserAndCar($idUser, $idCar): array|bool
    {
        $errors         = null;
        $foundedUser    = $this->findUser($idUser);
        $foundedCar     = $this->findCar($idCar);

        if (!$foundedCar) {
            $errors['errors'][] = [
                'error' => 'The requested car has not been found'
            ];
        }

        if (!$foundedUser) {
            $errors['errors'][] = [
                'error' => 'The requested user has not been found'
            ];
        }

        if ($errors) {
            return $errors;
        }
        return false;
    }
}
