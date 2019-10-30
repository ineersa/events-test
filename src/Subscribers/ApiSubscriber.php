<?php
namespace App\Subscribers;

use App\Events\UserBanned;
use App\Events\UserPayed;
use App\Events\UserRegistered;
use App\Interfaces\SubscriberInterface;
use App\Services\ApiService;

class ApiSubscriber implements SubscriberInterface
{
    private $service;

    public function __construct(ApiService $service)
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
        $this->service->sendBanned($event);
    }

    public function registered(UserRegistered $event)
    {
        $this->service->sendRegistered($event);
    }

    public function payed(UserPayed $event)
    {
        $this->service->sendPayed($event);
    }

    /**
     * @return ApiService
     */
    public function getService(): ApiService
    {
        return $this->service;
    }
}