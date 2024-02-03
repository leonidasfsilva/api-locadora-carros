<?php

namespace App\DTO\Users;

use App\Http\Requests\RequestUser;

class UpdateUserDTO
{
    public function __construct(public string $id, public string $name, public string $email)
    {
    }

    public static function makeFromRequest(RequestUser $request, string $id = null): self
    {
        return new self(
            $id ?? $request->id,
            $request->name,
            $request->email
        );
    }
}
