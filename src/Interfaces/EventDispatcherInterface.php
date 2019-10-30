<?php
namespace App\Interfaces;

interface EventDispatcherInterface
{
    public function addSubscriber(SubscriberInterface $subscriber) : void;

    public function dispatch(EventInterface $event) : void;
}