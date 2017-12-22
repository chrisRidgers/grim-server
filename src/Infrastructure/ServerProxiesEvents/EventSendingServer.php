<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Server;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Client;

class EventSendingServer implements Server
{
    private $sentEvents;
    private $clients;

    public function attachClient(Client $client)
    {
        $this->clients[$client->getClientName()] = $client;
    }

    public function getClient(string $clientName)
    {
        return $this->clients[$clientName];
    }

    public function getEventsSentToClient(string $clientName)
    {
        if (!$this->sentEvents[$clientName]) {
            return [];
        }

        foreach ($this->sentEvents[$clientName] as $event) {
            yield $event;
        }
    }

    public function receiveEvent(string $clientName, Event $event)
    {
        $this->sendEvent($clientName, $event);
    }

    public function sendEvent(string $clientName, Event $event)
    {
        foreach ($this->clients as $client) {
            $this->sentEvents[$client->getClientName()][] = $event;
        }
    }
}
