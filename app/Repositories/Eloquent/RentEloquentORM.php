<?php

namespace App\Repositories\Eloquent;

use App\DTO\Rent\RentDTO;
use App\Models\Rent;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\RentRepositoryInterface;
use App\Repositories\PaginationPresenter;
use stdClass;

class RentEloquentORM implements RentRepositoryInterface
{
    protected $table = 'cars_users_assoc AS cars_users_assoc';
    public function __construct(
        protected Rent $model
    ) {
    }

    public function paginate(int $idUser, ?int $page = 1, ?int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $cars_users_assoc = $this->model
            ->leftJoin('users AS u', 'cars_users_assoc.id_user', '=', 'u.id')
            ->leftJoin('cars AS c', 'c.id', '=', 'cars_users_assoc.id_car')
            ->select([
                '*'
                // 'cars_users_assoc.id_car',
                // 'c.model',
                // 'c.brand',
                // 'c.plate',
                // 'cars_users_assoc.created_at',
            ])
            // ->select('*')
            ->where('cars_users_assoc.status', 1)
            ->where('c.status', 1)
            ->where('u.status', 1)
            ->where('u.id', $idUser)
            ->orderBy('c.id', 'asc')
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($cars_users_assoc);
    }

    public function getAll(string $filter = null): array
    {
        return $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('brand', 'like', "%{$filter}%");
                    $query->orWhere('model', 'like', "%{$filter}%");
                    $query->orWhere('plate', 'like', "%{$filter}%");
                }
            })
            ->where('status', 1)
            ->get()
            ->toArray();
    }

    public function findRentByUser(string $idUser): stdClass|null
    {
        $rent = $this->model
            ->where('id_user', $idUser)
            ->where('status', 1);
        if (!$rent) {
            return null;
        }

        return (object) $rent->toArray();
    }

    public function findRentByCar(string $idCar): stdClass|null
    {
        $rent = $this->model
            ->where('id_car', $idCar)
            ->where('status', 1);
        if (!$rent) {
            return null;
        }

        return (object) $rent->toArray();
    }

    public function findRentedCarByUser(string $idCar, string $idUser): stdClass|bool
    {
        $rent = $this->model
            ->leftJoin('users AS u', 'cars_users_assoc.id_user', '=', 'u.id')
            ->leftJoin('cars AS c', 'c.id', '=', 'cars_users_assoc.id_car')
            ->select('*')
            ->where('cars_users_assoc.status', 1)
            ->where('c.id', $idCar)
            ->where('u.id', $idUser)
            ->get()
            ->toArray();

        if (!$rent) {
            return false;
        }
        return (object) current($rent);
    }

    public function returnCarByUser(string $idCar, string $idUser): ?bool
    {
        $this->model
            ->where('id_user', $idUser)
            ->where('id_car', $idCar)
            ->update([
                'status' => 0,
            ]);
        return true;
    }

    public function deleteFromCar(string $idCar): ?bool
    {
        $this->model
            ->where('id_car', $idCar)
            ->update([
                'status' => 0,
            ]);
        return true;
    }

    public function deleteFromUser(string $idUser): ?bool
    {
        $this->model
            ->where('id_user', $idUser)
            ->update([
                'status' => 0,
            ]);
        return true;
    }

    public function new(RentDTO $dto): stdClass
    {
        $rent = $this->model->create(
            (array) $dto
        );

        return $this->findRentedCarByUser($rent->id_car, $rent->id_user);
    }
}
