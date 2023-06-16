<?php

declare(strict_types=1);

namespace app\Helpers;

use Illuminate\Container\Container;

class ContainerAdapter implements \ContainerInterface
{
    public function resolve(string $abstract, array $parameters = []): object
    {
        return Container::getInstance()->make($abstract, $parameters);
    }
}
