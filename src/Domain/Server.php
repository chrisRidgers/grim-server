<?php
namespace Ridgers\Grim\Domain;

use Ridgers\Grim\Domain\Event;

interface Server
{
    public function sendEvent(string $clientName, Event $event);
    public function receiveEvent(string $clientName, Event $event);
}
