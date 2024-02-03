<?php

namespace App\DTO\Rent;

use App\Http\Requests\RequestRent;

class RentDTO
{
    public function __construct(public string $id_car, public string $id_user)
    {
    }

    public static function makeFromRequest(RequestRent $request, string $idUser = null): self
    {
        return new self(
            $request->id_car,
            $idUser ?? $request->id_user
        );
    }
}
