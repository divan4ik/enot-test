<?php

declare(strict_types=1);

namespace Repositories;

use Enot\Otp\Contracts\UserSettingsRepositoryInterface;

class UserSettingsEloquentRepository implements UserSettingsRepositoryInterface
{
    public function getVerifyMethodByUserId(string $userId): string
    {
        return 'telegram';
    }

}
