<?php

namespace App\Channels;

use App\Interfaces\ChannelInterface;
use App\Interfaces\EventInterface;
use App\Services\SQLService;

/**
 * Some dummy class to mock SQL.
 *
 * Class SQLService
 */
class SQLChannel implements ChannelInterface
{
    private $eventReceived;
    /**
     * @var SQLService
     */
    private $service;

    public function __construct(SQLService $service)
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
     * @return SQLService
     */
    public function getService(): SQLService
    {
        return $this->service;
    }
}
