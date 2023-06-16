<?php

declare(strict_types=1);

namespace Enot\Otp\Contracts;

interface OneTimePasswordsRepositoryInterface
{
    public function getCodeByUserId(string $userId): string;

    public function getAttemptsByUserId(string $userId): int;

    public function raiseAttemptsForUserId(string $userId): void;

    public function markAsClosed(string $userId): void;
}
