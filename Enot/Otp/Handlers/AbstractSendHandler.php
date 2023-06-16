<?php

declare(strict_types=1);

namespace Enot\Otp\Handlers;

use Enot\Otp\Contracts\UserSettingsRepositoryInterface;

abstract class AbstractSendHandler
{
    public function __construct(
        private UserSettingsRepositoryInterface $userSettingsRepository
    )
    {
    }
}
