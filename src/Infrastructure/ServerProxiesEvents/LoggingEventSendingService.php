<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\EventSendingService;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Client;

class LoggingEventSendingService implements EventSendingService {

    private $events = [];

    public function sendEvent(Client $client, Event $event)
    {
        $this->events[] = [
            'clientName' => $client->getClientName(),
            'event' => $event
        ];
    }

    public function getEventsSentToClient(Client $client)
    {
        foreach ($this->events as $event) {
            if ($client->getClientName() === $event['clientName']) {
                yield $event;
            }
        }
    }

    public function getLoggedSentEvents()
    {
        foreach ($this->events as $event) {
            yield $event;
        }
    }

}
