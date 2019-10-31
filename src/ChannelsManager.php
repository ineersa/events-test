<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\ChannelInterface;
use App\Interfaces\EventInterface;

class ChannelsManager
{
    /**
     * @var ChannelInterface[]
     */
    private $channels;

    public function addChannel(ChannelInterface $channel)
    {
        //TODO check if not already in
        $this->channels[] = $channel;
    }

    public function broadcast(EventInterface $event)
    {
        foreach ($this->channels as $channel) {
            $channel->broadcastEvent($event);
        }
    }

    public function clearChannels()
    {
        $this->channels = [];
    }
}
