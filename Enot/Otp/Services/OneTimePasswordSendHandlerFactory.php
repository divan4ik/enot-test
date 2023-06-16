<?php

declare(strict_types=1);

namespace Enot\Otp\Services;


use Enot\Common\Contracts\ContainerInterface;
use Enot\Otp\Contracts\OneTimePasswordSendHandlerInterface;
use Enot\Otp\Contracts\SendHandlersFactoryInterface;
use Enot\Otp\Exceptions\UknownSenderTypeException;
use Enot\Otp\Handlers\EmailSendHandler;
use Enot\Otp\Handlers\SmsSendHandler;
use Enot\Otp\Handlers\TelegramSendHandler;

class OneTimePasswordSendHandlerFactory implements SendHandlersFactoryInterface
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
        private ContainerInterface $di
    )
    {
    }

    public function getSender(string $name): OneTimePasswordSendHandlerInterface
    {
        if (!in_array($name, array_keys(self::$senders))) {
            throw new UknownSenderTypeException(sprintf('Отправитель %s не найден', $name));
        }

        return $this->di->resolve(self::$senders[$name]);
    }
}
