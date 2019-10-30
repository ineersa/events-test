<?php
declare(strict_types=1);

namespace App;

use App\Interfaces\EventDispatcherInterface;
use App\Interfaces\EventInterface;
use App\Interfaces\SubscriberInterface;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var SubscriberInterface[]
     */
    private $subscribers = [];

    public function addSubscriber(SubscriberInterface $subscriber): void
    {
        //check if it's not in subscribers already
        if (!array_key_exists(get_class($subscriber), $this->subscribers)) {
            $this->subscribers[get_class($subscriber)] = $subscriber;
        }
    }

    public function dispatch(EventInterface $event) : void
    {
        foreach ($this->subscribers as $class => $object) {
            $subscribedEvents = $object->getSubscribedEvents();
            if (
                array_key_exists(get_class($event), $subscribedEvents)
                && method_exists($object, $subscribedEvents[get_class($event)])
            ) {
                $methodName = $subscribedEvents[get_class($event)];
                $object->{$methodName}($event);
            }
        }
    }
}