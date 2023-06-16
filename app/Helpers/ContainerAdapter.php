<?php

declare(strict_types=1);

namespace app\Helpers;

use Enot\Common\Contracts\ContainerInterface;
use Illuminate\Container\Container;

class ContainerAdapter implements ContainerInterface
{
    public function resolve(string $abstract, array $parameters = []): object
    {
        return Container::getInstance()->make(
            abstract: $abstract,
            parameters: $parameters
        );
    }

    public function bind(string $abstract, string $concrete): void
    {
        Container::getInstance()->bind(
            abstract: $abstract,
            concrete: $concrete
        );
    }
}
