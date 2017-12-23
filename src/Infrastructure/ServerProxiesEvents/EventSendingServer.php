<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Server;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Client;
use Ridgers\Grim\Domain\ClientConnectionPool;
use Ridgers\Grim\Domain\EventSendingService;

class EventSendingServer implements Server
{
    private $sentEvents;
    private $clients;

    public function __construct(ClientConnectionPool $clientPool, EventSendingService $eventSendingService)
    {
        $this->clientPool = $clientPool;
        $this->eventSendingService = $eventSendingService;
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
        foreach ($this->clientPool->getClients() as $client) {
            $this->eventSendingService->sendEvent($client, $event);
        }
    }
}
