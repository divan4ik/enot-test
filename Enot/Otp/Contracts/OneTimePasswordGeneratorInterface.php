<?php

declare(strict_types=1);

namespace Enot\Otp\Contracts;

interface OneTimePasswordGeneratorInterface
{
    public static function generate(): string;
}
