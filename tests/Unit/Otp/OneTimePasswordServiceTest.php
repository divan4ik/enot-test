<?php

namespace Otp;

use Enot\Otp\Contracts\OneTimePasswordServiceInterface;
use Enot\Otp\Services\OneTimePasswordSender;
use Enot\Otp\Services\OneTimePasswordService;
use Enot\Otp\Services\OneTimePasswordValidator;
use Mockery;
use Tests\TestCase;

class OneTimePasswordServiceTest extends TestCase
{
    private OneTimePasswordServiceInterface $service;
    private string $userId = '1';
    private string $code = '0234';

    protected function setUp(): void
    {
        $sender = Mockery::mock(OneTimePasswordSender::class);
        $sender->shouldReceive('sendCode')
            ->with($this->userId)
            ->andReturn(null);
        $validator = Mockery::mock(OneTimePasswordValidator::class);
        $validator->shouldReceive('isValid')
            ->with($this->userId, $this->code)
            ->andReturn(true);
        $this->service = new OneTimePasswordService($sender, $validator);

        parent::setUp();
    }

    public function test_can_send_code(): void
    {
        $this->assertNull(
            $this->service->sendCode($this->userId)
        );
    }

    public function test_can_verify_code(): void
    {
        $this->assertTrue(
            $this->service->isValid($this->userId, $this->code)
        );
    }
}
