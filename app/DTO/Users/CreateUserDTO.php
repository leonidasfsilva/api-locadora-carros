<?php

namespace App\DTO\Users;

use App\Http\Requests\RequestUser;

class CreateUserDTO
{
    public function __construct(public string $name, public string $email)
    {
    }

    public static function makeFromRequest(RequestUser $request): self
    {
        return new self(
            $request->name,
            $request->email
        );
    }
}
