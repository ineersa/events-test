<?php

namespace App\Tests;

abstract class MockService
{
    private $callStack = [];

    public function __call($name, $arguments)
    {
        $this->callStack[] = [
            'method' => $name,
            'args' => $arguments,
        ];
    }

    /**
     * @return array
     */
    public function getCallStack(): array
    {
        return $this->callStack;
    }
}
