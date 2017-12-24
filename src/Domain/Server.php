<?php
namespace Ridgers\Grim\Domain;

use Ridgers\Grim\Domain\Event;

interface Server
{
    public function receiveEvent(Event $event);
}
