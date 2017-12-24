<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Server;
use Ridgers\Grim\Domain\Event;
use PHPUnit\Framework\TestCase;
use Ridgers\Grim\Domain\Client;

class EventsMatchingServer extends TestCase implements Server
{
    private $server;

    public function __construct($server)
    {
        $this->server = $server;
    }

    public function attachClient(Client $client)
    {
        $this->server->attachClient($client);
    }

    public function getClient(string $clientName)
    {
        return $this->server->getClient($clientName);
    }

    public function clientShouldHaveBeenSentEventMatchingEvent(Event $eventToMatch, Iterable $eventsSentToClient)
    {
        $callback = function ($haystack, $needle) {
            foreach ($haystack as $event) {
                if ($event == $needle) {
                    return true;
                }
            }
        };



        $this->assertTrue($callback($eventsSentToClient, $eventToMatch));
    }

    public function receiveEvent(Event $event)
    {
        $this->server->receiveEvent($event);
    }
}
