<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\EventDispatcherInterface;
use App\Interfaces\EventInterface;
use App\Interfaces\SubscriberInterface;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var ChannelsManager
     */
    private $channelsManager;

    public function __construct(ChannelsManager $channelsManager)
    {
        $this->channelsManager = $channelsManager;
    }

    public function dispatch(EventInterface $event): void
    {
        $this->channelsManager->broadcast($event);
    }
}
