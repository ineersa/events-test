<?php

namespace App\Channels;

use App\Interfaces\ChannelInterface;
use App\Interfaces\EventInterface;
use App\Services\ApiService;

/**
 * Some dummy class to mock SQL.
 *
 * Class SQLService
 */
class ApiChannel implements ChannelInterface
{
    private $eventReceived;

    /**
     * @var ApiService
     */
    private $service;

    public function __construct(ApiService $service)
    {
        $this->service = $service;
    }

    public function broadcastEvent(EventInterface $event)
    {
        $this->eventReceived = $event;
        //do logic here with event
        $this->getService()->processEvent($event);
    }

    /**
     * @return mixed
     */
    public function getEventReceived()
    {
        return $this->eventReceived;
    }

    /**
     * @return ApiService
     */
    public function getService(): ApiService
    {
        return $this->service;
    }
}
