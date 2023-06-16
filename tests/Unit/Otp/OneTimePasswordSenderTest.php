<?php

namespace Otp;

use Enot\Otp\Contracts\OneTimePasswordGeneratorInterface;
use Enot\Otp\Contracts\OneTimePasswordSendHandlerInterface;
use Enot\Otp\Contracts\OneTimePasswordsRepositoryInterface;
use Enot\Otp\Contracts\SendHandlersFactoryInterface;
use Enot\Otp\Contracts\UserSettingsRepositoryInterface;
use Enot\Otp\Services\OneTimePasswordSender;
use Illuminate\Queue\MaxAttemptsExceededException;
use Mockery;
use PHPUnit\Framework\TestCase;

class OneTimePasswordSenderTest extends TestCase
{
    private string $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userId = 1;
    }

    public function test_can_send_code_with_last_attempt(): void
    {
        $repositoryWithLastAttempt = Mockery::mock(OneTimePasswordsRepositoryInterface::class);
        $repositoryWithLastAttempt->shouldReceive('getAttemptsByUserId')
            ->with($this->userId)
            ->andReturn(2);

        $service = $this->getSender(passwordsRepository: $repositoryWithLastAttempt);

        $this->assertTrue($service->isAllowedToAttempt($this->userId));
        $void = $service->sendCode($this->userId);
        $this->assertNull($void);
    }

    public function test_cant_send_code_when_there_is_no_attempts(): void
    {
        $this->expectException(MaxAttemptsExceededException::class);
        $repositoryWithLastAttempt = Mockery::mock(OneTimePasswordsRepositoryInterface::class);
        $repositoryWithLastAttempt->shouldReceive('getAttemptsByUserId')
            ->with($this->userId)
            ->andReturn(3);

        $service = $this->getSender(passwordsRepository: $repositoryWithLastAttempt);
        $service->sendCode($this->userId);
    }

    private function getSender(
        $factory = null,
        $passwordsRepository = null,
        $settingsRepository = null
    ): OneTimePasswordSender
    {

        $codeGenerator = Mockery::mock(OneTimePasswordGeneratorInterface::class);
        $codeGenerator->shouldReceive('generate')
            ->andReturn('1234');

        $factory = $this->getMockedOrConfiguredFactory($factory);
        $settingsRepository = $this->getMockedOrConfiguredSettingsRepository($settingsRepository);
        $passwordsRepository = $this->getMockedOrConfiguredPasswordsRepository($passwordsRepository);

        return new OneTimePasswordSender(
            factory: $factory,
            userSettingsRepository: $settingsRepository,
            oneTimePasswordsRepository: $passwordsRepository,
            codeGenerator: $codeGenerator
        );
    }

    private function getMockedOrConfiguredSettingsRepository($repository = null)
    {
        if (is_null($repository)) {
            $repository = Mockery::mock(UserSettingsRepositoryInterface::class);
            $repository->shouldReceive('getVerifyMethodByUserId')
                ->with($this->userId)
                ->andReturn('telegram');
        }
        return $repository;
    }

    private function getMockedOrConfiguredPasswordsRepository($repository = null)
    {
        if (is_null($repository)) {
            $repository = Mockery::mock(OneTimePasswordsRepositoryInterface::class);
            $repository->shouldReceive('getAttemptsByUserId')
                ->with($this->userId)
                ->andReturn(2);

        }
        return $repository;
    }

    private function getMockedOrConfiguredFactory($factory = null)
    {
        if (is_null($factory)) {
            $handler = Mockery::mock(OneTimePasswordSendHandlerInterface::class);
            $handler->shouldReceive('send')
                ->andReturn(true);

            $factory = Mockery::mock(SendHandlersFactoryInterface::class);
            $factory->shouldReceive('getSender')
                ->with('telegram')
                ->andReturn($handler);
        }
        return $factory;
    }
}
