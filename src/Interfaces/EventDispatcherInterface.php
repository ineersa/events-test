<?php

namespace App\Interfaces;

interface EventDispatcherInterface
{
    public function dispatch(EventInterface $event): void;
}
