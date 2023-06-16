<?php

declare(strict_types=1);

namespace app\Helpers;

use Illuminate\Support\Facades\Auth;

class UserAdapter implements \UserInterface
{
    public function getId(): string|null
    {
        return (string) Auth::id() ?? null;
    }
}
