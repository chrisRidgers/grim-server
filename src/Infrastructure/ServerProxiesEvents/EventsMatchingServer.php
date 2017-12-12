<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Server;
use Ridgers\Grim\Domain\Event;
use PHPUnit\Framework\TestCase;

class EventsMatchingServer extends TestCase implements Server
{
    private $server;

    public function __construct($server)
    {
        $this->server = $server;
    }

    public function eventMatchingEventShouldHaveBeenSent(Event $eventToMatch)
    {
        $callback = function ($haystack, $needle) {
            foreach ($haystack as $event) {
                if ($event == $needle) {
                    return true;
                }
            }
        };

        $this->assertTrue($callback($this->getSentEvents(), $eventToMatch));
    }

    public function getSentEvents()
    {
        return $this->server->getSentEvents();
    }

    public function sendEvent(Event $event)
    {
        $this->server->sendEvent($event);
    }

    public function receiveEvent(Event $event)
    {
        $this->server->receiveEvent($event);
    }

}
