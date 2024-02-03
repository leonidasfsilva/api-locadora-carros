<?php

namespace App\Services;

use App\DTO\Cars\CreateCarDTO;
use App\DTO\Cars\UpdateCarDTO;
use App\Models\Rent;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\CarRepositoryInterface;
use App\Repositories\Eloquent\RentEloquentORM;
use stdClass;

class CarService
{
    public function __construct(
        protected CarRepositoryInterface $repository,
    ) {
    }

    public function paginate(?int $page = 1, ?int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function getAll(string $filter = null): array
    {
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateCarDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }

    public function update(UpdateCarDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $rentModel      = new Rent();
        $rentRepository = new RentEloquentORM($rentModel);
        $rentService    = new RentService($rentRepository);

        $rentService->deleteFromCar($id);

        $this->repository->delete($id);
    }
}
