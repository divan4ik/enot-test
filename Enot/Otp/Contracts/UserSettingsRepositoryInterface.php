<?php

declare(strict_types=1);

namespace Enot\Otp\Contracts;

interface UserSettingsRepositoryInterface
{
    public function getVerifyMethodByUserId(string $userId): string;
}
