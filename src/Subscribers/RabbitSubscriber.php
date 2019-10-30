<?php

namespace App\Subscribers;

use App\Events\UserBanned;
use App\Events\UserPayed;
use App\Events\UserRegistered;
use App\Interfaces\SubscriberInterface;
use App\Services\RabbitService;

class RabbitSubscriber implements SubscriberInterface
{
    private $service;

    public function __construct(RabbitService $service)
    {
        $this->service = $service;
    }

    public function getSubscribedEvents(): array
    {
        return [
            UserBanned::class => 'banned',
            UserRegistered::class => 'registered',
            UserPayed::class => 'payed',
        ];
    }

    public function banned(UserBanned $event)
    {
        $this->service->queueBanned($event);
    }

    public function registered(UserRegistered $event)
    {
        $this->service->queueRegistered($event);
    }

    public function payed(UserPayed $event)
    {
        $this->service->queuePayed($event);
    }

    /**
     * @return RabbitService
     */
    public function getService(): RabbitService
    {
        return $this->service;
    }
}
