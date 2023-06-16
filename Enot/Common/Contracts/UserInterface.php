<?php

declare(strict_types=1);

namespace Enot\Common\Contracts;

interface UserInterface
{
    public function getId(): string|null;
}
