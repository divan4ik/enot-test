<?php

namespace Otp;

use Enot\Otp\Contracts\OneTimePasswordsRepositoryInterface;
use Enot\Otp\Services\OneTimePasswordValidator;
use Mockery;
use PHPUnit\Framework\TestCase;

class OneTimePasswordValidatorTest extends TestCase
{
    private string $userId = '1';
    private string $code = '0123';
    private OneTimePasswordValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $repository = Mockery::mock(OneTimePasswordsRepositoryInterface::class);
        $repository->shouldReceive('getCodeByUserId')
            ->with($this->userId)
            ->andReturn($this->code);

        $repository->shouldReceive('markAsClosed')
            ->andReturn(null);

        $this->validator = new OneTimePasswordValidator($repository);
    }
    public function test_can_verify_code(): void
    {
        $this->assertTrue(
            $this->validator->isValid(
                $this->userId,
                $this->code
            )
        );
    }
}
