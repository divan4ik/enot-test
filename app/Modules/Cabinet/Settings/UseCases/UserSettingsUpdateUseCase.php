<?php

declare(strict_types=1);

use Enot\Otp\Contracts\OneTimePasswordServiceInterface;

class UserSettingsUpdateUseCase
{
    public function __construct(
        private OneTimePasswordServiceInterface $otpService,
        private UserInterface $user
    )
    {
    }

    public function execute(array $dto): void
    {
        //..

        $this->otpService->isValid($this->user->getId(), $dto['verification_code']);

        //..
    }
}
