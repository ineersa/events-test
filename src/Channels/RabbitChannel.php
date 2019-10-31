<?php

namespace App\Channels;

use App\Interfaces\ChannelInterface;
use App\Interfaces\EventInterface;
use App\Services\RabbitService;

class RabbitChannel implements ChannelInterface
{
    private $eventReceived;

    /**
     * @var RabbitService
     */
    private $service;

    public function __construct(RabbitService $service)
    {
        $this->service = $service;
    }

    public function broadcastEvent(EventInterface $event)
    {
        $this->eventReceived = $event;
        //do logic here with
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
     * @return RabbitService
     */
    public function getService(): RabbitService
    {
        return $this->service;
    }
}
