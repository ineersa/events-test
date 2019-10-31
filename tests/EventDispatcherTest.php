<?php

namespace App\Tests;

use App\Channels\ApiChannel;
use App\Channels\RabbitChannel;
use App\ChannelsManager;
use App\EventDispatcher;
use App\Events\UserBanned;
use App\Events\UserPayed;
use App\Events\UserRegistered;

use App\Channels\SQLChannel;
use App\Interfaces\ChannelInterface;
use App\Interfaces\EventInterface;
use App\Services\ApiService;
use App\Services\RabbitService;
use App\Services\SQLService;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{

    private $userBannedEvent;
    private $userPayedEvent;
    private $userRegisteredEvent;
    /**
     * @var RabbitChannel
     */
    private $rabbitChannel;
    /**
     * @var ApiChannel
     */
    private $apiChannel;
    /**
     * @var SQLChannel
     */
    private $sqlChannel;
    /**
     * @var ChannelsManager
     */
    private $channelsManager;

    public function setUp(): void
    {
        $this->apiChannel = new ApiChannel((new ApiService()));
        $this->rabbitChannel = new RabbitChannel((new RabbitService()));
        $this->sqlChannel = new SQLChannel((new SQLService()));

        $this->channelsManager = new ChannelsManager();

        $this->userBannedEvent = new UserBanned(time(), 1, 'banned');
        $this->userPayedEvent = new UserPayed(time(), 1, 100);
        $this->userRegisteredEvent = new UserRegistered(time(), 1, 'test');

        parent::setUp();
    }

    public function tearDown(): void
    {
        $this->channelsManager->clearChannels();

        parent::tearDown();
    }

    public function testSQLChannel()
    {
        $this->channelsManager->addChannel($this->sqlChannel);
        $eventDispatcher = new EventDispatcher($this->channelsManager);

        $eventDispatcher->dispatch($this->userBannedEvent);

        $this->assertNotEmpty($this->sqlChannel->getEventReceived());
        $this->assertEquals($this->userBannedEvent, $this->sqlChannel->getEventReceived());
        $this->assertEquals($this->userBannedEvent, $this->sqlChannel->getService()->getProcessedEvent());
    }

    public function testAllChannels()
    {
        $this->channelsManager->addChannel($this->sqlChannel);
        $this->channelsManager->addChannel($this->apiChannel);
        $this->channelsManager->addChannel($this->rabbitChannel);
        $eventDispatcher = new EventDispatcher($this->channelsManager);

        $eventDispatcher->dispatch($this->userRegisteredEvent);

        $this->assertNotEmpty($this->sqlChannel->getEventReceived());
        $this->assertNotEmpty($this->apiChannel->getEventReceived());
        $this->assertNotEmpty($this->rabbitChannel->getEventReceived());

        $this->assertEquals($this->userRegisteredEvent, $this->sqlChannel->getEventReceived());
        $this->assertEquals($this->userRegisteredEvent, $this->apiChannel->getEventReceived());
        $this->assertEquals($this->userRegisteredEvent, $this->rabbitChannel->getEventReceived());

        $this->assertEquals($this->userRegisteredEvent, $this->sqlChannel->getService()->getProcessedEvent());
        $this->assertEquals($this->userRegisteredEvent, $this->apiChannel->getService()->getProcessedEvent());
        $this->assertEquals($this->userRegisteredEvent, $this->rabbitChannel->getService()->getProcessedEvent());
    }

    public function testAddNewEvent()
    {
        //init channels manager and dispatcher
        $this->channelsManager->addChannel($this->sqlChannel);
        $this->channelsManager->addChannel($this->apiChannel);
        $this->channelsManager->addChannel($this->rabbitChannel);
        $eventDispatcher = new EventDispatcher($this->channelsManager);

        $testEvent = new TestNewEvent();

        $eventDispatcher->dispatch($testEvent);

        $this->assertNotEmpty($this->sqlChannel->getEventReceived());
        $this->assertEquals($testEvent, $this->sqlChannel->getEventReceived());
        $this->assertEquals($testEvent, $this->sqlChannel->getService()->getProcessedEvent());
        $this->assertEquals('TEST', $this->sqlChannel->getService()->getProcessedEvent()->getName());
    }

    public function testAddNewChannel()
    {
        //init channels manager and dispatcher
        $channel = new TestNewChannel();
        $this->channelsManager->addChannel($channel);
        $eventDispatcher = new EventDispatcher($this->channelsManager);

        $testEvent = new TestNewEvent();

        $eventDispatcher->dispatch($testEvent);

        $this->assertNotEmpty($channel->getEventReceived());
        $this->assertEquals($testEvent, $channel->getEventReceived());
        $this->assertEquals('TEST', $channel->getEventReceived()->getName());
    }

}

class TestNewEvent implements EventInterface
{
    public function getName()
    {
        return 'TEST';
    }
}

class TestNewChannel implements ChannelInterface
{
    private $eventReceived;

    public function broadcastEvent(EventInterface $event)
    {
        $this->eventReceived = $event;
        // proceed to logic further
    }

    /**
     * @return mixed
     */
    public function getEventReceived()
    {
        return $this->eventReceived;
    }
}