<?php

declare(strict_types=1);

namespace Enot\Otp\Services;

use Enot\Otp\Contracts\OneTimePasswordSendHandlerInterface;
use Enot\Otp\Contracts\SendHandlersFactoryInterface;
use Enot\Otp\Contracts\UserSettingsRepositoryInterface;
use Enot\Otp\Exceptions\UnableToSendOneTimePasswordException;
use Enot\Otp\Contracts\OneTimePasswordGeneratorInterface;
use Enot\Otp\Contracts\OneTimePasswordsRepositoryInterface;
use Illuminate\Queue\MaxAttemptsExceededException;

class OneTimePasswordSender
{
    public function __construct(
        private SendHandlersFactoryInterface        $factory,
        private UserSettingsRepositoryInterface     $userSettingsRepository,
        private OneTimePasswordsRepositoryInterface $oneTimePasswordsRepository,
        private OneTimePasswordGeneratorInterface   $codeGenerator
    )
    {
    }

    public function sendCode(string $userId): void
    {
        $method = $this->userSettingsRepository->getVerifyMethodByUserId($userId);
        $codeSender = $this->factory->getSender($method);

        if (!$this->isAllowedToAttempt($userId)) {
            throw new MaxAttemptsExceededException('Превышено допустимое кол-во попыток');
        }

        try {
            $code = $this->codeGenerator->generate();
            $codeSender->send($userId, $code);
        } catch (\Throwable $e) {
            throw new UnableToSendOneTimePasswordException($e->getMessage());
        }
    }

    public function isAllowedToAttempt(string $userId): bool
    {
        return $this->oneTimePasswordsRepository->getAttemptsByUserId($userId) < OneTimePasswordService::MAX_ATTEMPTS;
    }
}
