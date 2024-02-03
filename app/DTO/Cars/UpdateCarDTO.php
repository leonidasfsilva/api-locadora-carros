<?php

namespace App\DTO\Cars;

use App\Http\Requests\RequestCar;

class UpdateCarDTO
{
    public function __construct(public string $id, public string $model, public string $brand, public string $plate)
    {
    }

    public static function makeFromRequest(RequestCar $request, string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->model,
            $request->brand,
            $request->plate
        );
    }
}
