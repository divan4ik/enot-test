<?php

declare(strict_types=1);

namespace Enot\Otp\Services;

use Exceptions\UknownSenderTypeException;
use Handlers\EmailSendHandler;
use Handlers\SmsSendHandler;
use Handlers\TelegramSendHandler;

class OneTimePasswordSendHandlerFactory
{
    private const SENDER_TELEGRAM_NAME = 'telegram';
    private const SENDER_EMAIL_NAME = 'email';
    private const SENDER_SMS_NAME = 'sms';

    private static array $senders = [
        self::SENDER_TELEGRAM_NAME => TelegramSendHandler::class,
        self::SENDER_EMAIL_NAME => EmailSendHandler::class,
        self::SENDER_SMS_NAME => SmsSendHandler::class,
    ];

    public function __construct(
        private \ContainerInterface $di
    )
    {
    }

    public function getSender(string $name): \OneTimePasswordSendHandlerInterface
    {
        if (!in_array($name, self::$senders)) {
            throw new UknownSenderTypeException(sprintf('Отправитель %s не найден', $name));
        }

        $this->di->resolve(self::$senders[$name]);
    }
}
