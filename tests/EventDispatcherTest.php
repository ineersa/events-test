<?php
namespace App\Tests;

use App\EventDispatcher;
use App\Events\UserBanned;
use App\Events\UserPayed;
use App\Events\UserRegistered;
use App\Services\ApiService;
use App\Services\RabbitService;
use App\Services\SQLService;
use App\Subscribers\ApiSubscriber;
use App\Subscribers\RabbitSubscriber;
use App\Subscribers\SQLSubscriber;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    private $apiSubscriber;
    private $rabbitSubscriber;
    private $sqlSubscriber;
    private $userBannedEvent;
    private $userPayedEvent;
    private $userRegisteredEvent;

    public function setUp(): void
    {
        $apiService = new ApiService();
        $sqlService = new SQLService();
        $rabbitService = new RabbitService();
        $this->apiSubscriber = new ApiSubscriber($apiService);
        $this->rabbitSubscriber = new RabbitSubscriber($rabbitService);
        $this->sqlSubscriber = new SQLSubscriber($sqlService);

        $this->userBannedEvent = new UserBanned(time(), 1, 'banned');
        $this->userPayedEvent = new UserPayed(time(), 1, 100);
        $this->userRegisteredEvent = new UserRegistered(time(), 1, 'test');

        parent::setUp();
    }

    public function testSQLChannel()
    {
        $sqlSubscriber = clone $this->sqlSubscriber;
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($sqlSubscriber);
        $eventDispatcher->dispatch($this->userRegisteredEvent);

        $callStack = $sqlSubscriber->getService()->getCallStack();
        $this->assertNotEmpty($callStack);
        $this->assertEquals('saveRegistered', $callStack[0]['method']);
        $this->assertEquals($this->userRegisteredEvent, $callStack[0]['args'][0]);
    }

    public function testAllChannels()
    {
        $sqlSubscriber = clone $this->sqlSubscriber;
        $apiSubscriber = clone $this->apiSubscriber;
        $rabbitSubscriber = clone $this->rabbitSubscriber;

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($sqlSubscriber);
        $eventDispatcher->addSubscriber($apiSubscriber);
        $eventDispatcher->addSubscriber($rabbitSubscriber);

        $eventDispatcher->dispatch($this->userBannedEvent);

        $callStack = $apiSubscriber->getService()->getCallStack();
        $this->assertNotEmpty($callStack);
        $this->assertEquals('sendBanned', $callStack[0]['method']);
        $this->assertEquals($this->userBannedEvent, $callStack[0]['args'][0]);

        $callStack = $rabbitSubscriber->getService()->getCallStack();
        $this->assertNotEmpty($callStack);
        $this->assertEquals('queueBanned', $callStack[0]['method']);
        $this->assertEquals($this->userBannedEvent, $callStack[0]['args'][0]);
    }
}