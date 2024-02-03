<?php

namespace App\DTO\Cars;

use App\Http\Requests\RequestCar;

class CreateCarDTO
{
    public function __construct(public string $model, public string $brand, public string $plate)
    {
    }

    public static function makeFromRequest(RequestCar $request): self
    {
        return new self(
            $request->model,
            $request->brand,
            $request->plate
        );
    }
}
