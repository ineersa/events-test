<?php
namespace App\Tests;

use App\EventDispatcher;
use App\Interfaces\EventInterface;
use App\Interfaces\SubscriberInterface;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    public function testAddSubscriber()
    {
        $testSubscriber = new TestSubscriber();
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($testSubscriber);
        $reflection = new \ReflectionObject($eventDispatcher);
        $subscribers = $reflection->getProperty('subscribers');
        $subscribers->setAccessible(true);
        $subscribersArray = $subscribers->getValue($eventDispatcher);
        $this->assertNotEmpty($subscribersArray);
        $this->assertArrayHasKey("App\Tests\TestSubscriber", $subscribersArray);
        $this->assertContains($testSubscriber, $subscribersArray);
    }

    public function testDispatch()
    {
        $testSubscriber = new TestSubscriber();
        $testEvent = new TestEvent();
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($testSubscriber);
        $eventDispatcher->dispatch($testEvent);

        $this->assertTrue($testSubscriber->isEventReceived);
        $this->assertEquals('TEST', $testSubscriber->eventName);
    }
}

class TestSubscriber implements SubscriberInterface
{

    public $isEventReceived = false;
    public $eventName = '';

    public function getSubscribedEvents(): array
    {
        return [
            TestEvent::class => 'testEvent'
        ];
    }

    public function testEvent(TestEvent $event)
    {
        $this->isEventReceived = true;
        $this->eventName = $event->name;
    }
}

class TestEvent implements EventInterface
{
    public $name = 'TEST';
}