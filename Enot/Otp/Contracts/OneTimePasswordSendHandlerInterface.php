<?php

declare(strict_types=1);

namespace Enot\Otp\Contracts;

interface OneTimePasswordSendHandlerInterface
{
    public function send(string $userId, string $code): void;
}
