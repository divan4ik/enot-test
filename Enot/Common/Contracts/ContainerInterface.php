<?php

declare(strict_types=1);

namespace Enot\Common\Contracts;

interface ContainerInterface
{
    public function resolve(string $abstract, array $parameters = []): object;


}
