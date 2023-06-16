<?php

declare(strict_types=1);

namespace Enot\Otp\Services;

use Enot\Otp\Contracts\OneTimePasswordsRepositoryInterface;
use Enot\Otp\Exceptions\UnableToCheckOneTimePasswordException;
use Illuminate\Queue\MaxAttemptsExceededException;

class OneTimePasswordValidator
{

    public function __construct(
        private OneTimePasswordsRepositoryInterface $oneTimePasswordsRepository
    )
    {
    }

    public function isValid(string $userId, string $code): bool
    {
        if (!$this->isAllowedToAttempt($userId)) {
            throw new MaxAttemptsExceededException('Достигнуто максимальное кол-во попыток');
        }

        try {
            $realCode = $this->oneTimePasswordsRepository->getCodeByUserId($userId);

            if ($realCode !== $code) {
                $this->oneTimePasswordsRepository->raiseAttemptsForUserId($userId);
                return false;
            }

            $this->oneTimePasswordsRepository->markAsClosed($userId);
            return true;

        } catch (\Throwable $e) {
            throw new UnableToCheckOneTimePasswordException($e->getMessage());
        }
    }


    public function isAllowedToAttempt(string $userId): bool
    {
        return true;
    }
}
