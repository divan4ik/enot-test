<?php

declare(strict_types=1);

namespace Enot\Otp\Handlers;

use Enot\Otp\Contracts\OneTimePasswordSendHandlerInterface;

class SmsSendHandler extends AbstractSendHandler implements OneTimePasswordSendHandlerInterface
{
    public function send(string $userId, string $code): void
    {
        // TODO: Implement send() method.
    }

}
