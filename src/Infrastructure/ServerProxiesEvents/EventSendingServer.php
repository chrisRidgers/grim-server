<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Server;
use Ridgers\Grim\Domain\Event;

class EventSendingServer implements Server
{
    private $sentEvents;

    public function getSentEvents()
    {
        foreach ($this->sentEvents as $event) {
            yield $event;
        }
    }

    public function receiveEvent(Event $event)
    {
        $this->sendEvent($event);
    }

    public function sendEvent(Event $event)
    {
        $this->sentEvents[] = $event;
    }
}
