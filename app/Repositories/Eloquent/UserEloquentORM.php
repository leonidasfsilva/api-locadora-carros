<?php

namespace App\Repositories\Eloquent;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PaginationPresenter;
use Illuminate\Support\Facades\DB;
use stdClass;

class UserEloquentORM implements UserRepositoryInterface
{
    protected $table;
    public function __construct(protected User $model)
    {
    }

    public function paginate(?int $page = 1, ?int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('name', 'like', "%{$filter}%");
                    $query->orWhere('email', 'like', "%{$filter}%");
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
                    $query->where('name', 'like', "%{$filter}%");
                    $query->orWhere('email', 'like', "%{$filter}%");
                }
            })
            ->where('status', 1)
            ->get()
            ->toArray();
    }

    public function findOne(string $id): stdClass|null
    {
        $user = $this->model
            ->where('status', 1)
            ->find($id);
        if (!$user) {
            return null;
        }

        return (object) $user->toArray();
    }

    public function findRents(string $id): PaginationInterface
    {
        $rents = (object) DB::table('cars_users_assoc AS assoc')
            ->leftJoin('users AS u', 'rents.id_user', '=', 'u.id')
            ->leftJoin('cars AS c', 'c.id', '=', 'rents.id_car')
            ->select('*')
            ->where('rents.status', 1)
            ->where('u.id', $id)
            ->paginate();

        // if (!$rents) {
        //     return null;
        // }

        return new PaginationPresenter($rents);
    }

    public function delete(string $id): ?bool
    {
        $this->model
            ->where('id', $id)
            ->update([
                'status' => 0,
            ]);
        return true;
    }

    public function new(CreateUserDTO $dto): stdClass
    {
        $user = $this->model->create(
            (array) $dto
        );

        return (object) $user->toArray();
    }

    public function update(UpdateUserDTO $dto): stdClass|null
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
