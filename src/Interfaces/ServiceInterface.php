<?php
namespace App\Interfaces;

interface ServiceInterface
{
    public function processEvent(EventInterface $event);
}