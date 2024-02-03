<?php

namespace App\Services;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserDTO;
use App\Models\Rent;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\RentEloquentORM;
use stdClass;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository,
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

    public function findRents(string $id): PaginationInterface
    {
        return $this->repository->findRents($id);
    }

    public function new(CreateUserDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }

    public function update(UpdateUserDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $rentModel      = new Rent();
        $rentRepository = new RentEloquentORM($rentModel);
        $rentService    = new RentService($rentRepository);

        $rentService->deleteFromUser($id);

        $this->repository->delete($id);
    }
}
