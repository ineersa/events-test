<?php

namespace App\Subscribers;

use App\Events\UserBanned;
use App\Events\UserPayed;
use App\Events\UserRegistered;
use App\Interfaces\SubscriberInterface;
use App\Services\SQLService;

class SQLSubscriber implements SubscriberInterface
{
    private $service;

    public function __construct(SQLService $service)
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
        $this->service->saveBanned($event);
    }

    public function registered(UserRegistered $event)
    {
        $this->service->saveRegistered($event);
    }

    public function payed(UserPayed $event)
    {
        $this->service->savePayed($event);
    }

    /**
     * @return SQLService
     */
    public function getService(): SQLService
    {
        return $this->service;
    }
}
