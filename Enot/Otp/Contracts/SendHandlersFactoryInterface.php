<?php

declare(strict_types=1);

namespace Enot\Otp\Contracts;

interface SendHandlersFactoryInterface
{
    public function getSender(string $method): OneTimePasswordSendHandlerInterface;
}
