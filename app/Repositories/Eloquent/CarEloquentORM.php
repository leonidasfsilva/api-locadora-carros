<?php

namespace App\Repositories\Eloquent;

use App\DTO\Cars\CreateCarDTO;
use App\DTO\Cars\UpdateCarDTO;
use App\Models\Car;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\CarRepositoryInterface;
use App\Repositories\PaginationPresenter;
use stdClass;

class CarEloquentORM implements CarRepositoryInterface
{
    public function __construct(
        protected Car $model
    ) {
    }

    public function paginate(?int $page = 1, ?int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('brand', 'like', "%{$filter}%");
                    $query->orWhere('model', 'like', "%{$filter}%");
                    $query->orWhere('plate', 'like', "%{$filter}%");
                }
            })
            ->where('status', 1)
            ->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
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

    public function findOne(string $id): stdClass|null
    {
        $support = $this->model
            ->where('status', 1)
            ->find($id);
        if (!$support) {
            return null;
        }

        return (object) $support->toArray();
    }

    public function delete(string $id): ?bool
    {
        if (!$this->model->find($id)) {
            return null;
        }

        $this->model
            ->where('id', $id)
            ->update([
                'status' => 0,
            ]);
        return true;
    }

    public function new(CreateCarDTO $dto): stdClass
    {
        $support = $this->model->create(
            (array) $dto
        );

        return (object) $support->toArray();
    }

    public function update(UpdateCarDTO $dto): stdClass|null
    {
        if (!$support = $this->model->find($dto->id)) {
            return null;
        }

        $support->update(
            (array) $dto
        );

        return (object) $support->toArray();
    }
}
