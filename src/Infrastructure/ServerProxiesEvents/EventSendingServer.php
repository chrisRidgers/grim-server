<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Server;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Client;
use Ridgers\Grim\Domain\ClientConnectionPool;
use Ridgers\Grim\Domain\EventSendingService;

class EventSendingServer implements Server
{
    public function __construct(ClientConnectionPool $clientPool, EventSendingService $eventSendingService)
    {
        $this->clientPool = $clientPool;
        $this->eventSendingService = $eventSendingService;
    }

    public function attachClient(string $clientName)
    {
        $this->clientPool->attachClient($clientName);
    }
    
    public function receiveEvent(Event $event)
    {
        $this->sendEvent($event);
    }

    public function sendEvent(Event $event)
    {
        foreach ($this->clientPool->getClients() as $client) {
            $this->eventSendingService->sendEvent($client, $event);
        }
    }
}
