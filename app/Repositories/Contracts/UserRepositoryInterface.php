<?php

namespace App\Repositories\Contracts;

use App\DTO\Users\{
    CreateUserDTO,
    UpdateUserDTO
};
use stdClass;

interface UserRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function findRents(string $id): PaginationInterface;
    public function delete(string $id): ?bool;
    public function new(CreateUserDTO $dto): stdClass;
    public function update(UpdateUserDTO $dto): stdClass|null;
}
