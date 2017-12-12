<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Client;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Server;

class DummyClient implements Client
{
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function sendEvent(Event $event)
    {
        $this->server->receiveEvent($event);
    }
}
