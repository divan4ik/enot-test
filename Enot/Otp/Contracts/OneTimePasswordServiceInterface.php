<?php

declare(strict_types=1);

namespace Enot\Otp\Contracts;

interface OneTimePasswordServiceInterface
{
    public function sendCode(string $userId): void;
    public function isValid(string $userId, string $code): bool;
}
