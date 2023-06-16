<?php

declare(strict_types=1);

namespace Enot\Otp\Services;

use DomainException;
use Enot\Otp\Contracts\OneTimePasswordServiceInterface;
use Enot\Otp\Exceptions\UnableToCheckOneTimePasswordException;
use Enot\Otp\Exceptions\UnableToSendOneTimePasswordException;

class OneTimePasswordService implements OneTimePasswordServiceInterface
{
    public const MAX_ATTEMPTS = 3;

    public function __construct(
        private OneTimePasswordSender    $sender,
        private OneTimePasswordValidator $validator,
    )
    {
    }

    public function sendCode(string $userId): void
    {
        try {
            $this->sender->sendCode($userId);
        } catch (UnableToSendOneTimePasswordException $e) {
            throw new DomainException($e->getMessage());
        }

    }

    public function isValid(string $userId, string $code): bool
    {
        try {
            return $this->validator->isValid($userId, $code);
        } catch (UnableToCheckOneTimePasswordException $e) {
            throw new DomainException($e->getMessage());
        }
    }
}
