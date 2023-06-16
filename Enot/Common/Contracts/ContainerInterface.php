<?php

declare(strict_types=1);

interface ContainerInterface
{
    public function resolve(string $abstract, array $parameters = []): object;
}
