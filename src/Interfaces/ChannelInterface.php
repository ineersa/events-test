<?php
namespace App\Interfaces;

interface ChannelInterface
{
    public function broadcastEvent(EventInterface $event);
}