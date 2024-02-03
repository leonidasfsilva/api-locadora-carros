<?php

namespace App\Repositories\Contracts;

use App\DTO\Cars\{
    CreateCarDTO,
    UpdateCarDTO
};
use stdClass;

interface CarRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): ?bool;
    public function new(CreateCarDTO $dto): stdClass;
    public function update(UpdateCarDTO $dto): stdClass|null;
}
