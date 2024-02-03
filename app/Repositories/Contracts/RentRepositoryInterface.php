<?php

namespace App\Repositories\Contracts;

use App\DTO\Rent\RentDTO;
use stdClass;

interface RentRepositoryInterface
{
    public function paginate(int $idUser, int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findRentByUser(string $idUser): stdClass|null;
    public function findRentByCar(string $idCar): stdClass|null;
    public function findRentedCarByUser(string $idCar, string $idUser): stdClass|bool;
    public function returnCarByUser(string $idCar, string $idUser): ?bool;
    public function deleteFromCar(string $idCar): ?bool;
    public function deleteFromUser(string $idUser): ?bool;
    public function new(RentDTO $dto): stdClass;
}
