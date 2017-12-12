<?php
namespace Ridgers\Grim\Domain;

use Ridgers\Grim\Domain\Event;

interface Server
{
    public function sendEvent(Event $event);
    public function receiveEvent(Event $event);
    public function getSentEvents();
}
