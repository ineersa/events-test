<?php
namespace App\Services;

use App\Interfaces\EventInterface;
use App\Interfaces\ServiceInterface;
use App\Tests\MockService;

class SQLService extends MockService implements ServiceInterface
{
    private $processedEvent;

    public function processEvent(EventInterface $event)
    {
        $this->processedEvent = $event;
        //do logic here
    }

    /**
     * @return mixed
     */
    public function getProcessedEvent()
    {
        return $this->processedEvent;
    }
}