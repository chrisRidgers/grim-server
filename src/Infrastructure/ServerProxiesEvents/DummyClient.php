<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Client;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Server;

class DummyClient implements Client
{
    private $server;
    private $clientName;

    public function __construct(string $clientName, Server $server)
    {
        $this->clientName = $clientName;
        $this->server = $server;
    }

    public function getClientName()
    {
        return $this->clientName;
    }

    public function sendEvent(Event $event)
    {
        $this->server->receiveEvent($this->clientName, $event);
    }
}
