<?php

namespace App\Interfaces;

interface SubscriberInterface
{
    public function getSubscribedEvents(): array;
}
