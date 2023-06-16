<?php

namespace Otp;

use App\Helpers\ContainerAdapter;
use Enot\Otp\Contracts\SendHandlersFactoryInterface;
use Enot\Otp\Contracts\UserSettingsRepositoryInterface;
use Enot\Otp\Exceptions\UknownSenderTypeException;
use Enot\Otp\Handlers\EmailSendHandler;
use Enot\Otp\Handlers\SmsSendHandler;
use Enot\Otp\Handlers\TelegramSendHandler;
use Enot\Otp\Services\OneTimePasswordSendHandlerFactory;

use Mockery;
use Tests\TestCase;

class SendHandlerFactoryTest extends TestCase
{
    private SendHandlersFactoryInterface $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bindDependencies();

        $this->service = new OneTimePasswordSendHandlerFactory(
            new ContainerAdapter()
        );
    }

    public function test_can_get_sms_sender(): void
    {
        $smsSender = $this->service->getSender('sms');
        $this->assertInstanceOf(SmsSendHandler::class, $smsSender);
    }

    public function test_can_get_telegram_sender(): void
    {
        $smsSender = $this->service->getSender('telegram');
        $this->assertInstanceOf(TelegramSendHandler::class, $smsSender);
    }

    public function test_can_get_email_sender(): void
    {
        $smsSender = $this->service->getSender('email');
        $this->assertInstanceOf(EmailSendHandler::class, $smsSender);
    }

    public function test_throws_exception_on_unknown_sender_name(): void
    {
        $this->expectException(UknownSenderTypeException::class);
        $unknownSender = $this->service->getSender('watsapp');
        unset($unknownSender);
    }

    private function bindDependencies()
    {
        $this->app->singleton(
            UserSettingsRepositoryInterface::class,
            fn () => Mockery::mock(UserSettingsRepositoryInterface::class)
        );
    }
}
