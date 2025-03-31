<?php

namespace App\Contracts;

interface CommandBusInterface
{
    public function addHandler(string $command, string $handler);
    public function dispatch(object $command, array $middleware = []);
}
