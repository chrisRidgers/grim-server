<?php
namespace Ridgers\Grim\Tests\Helpers;

use Ridgers\Grim\Domain\EventSendingService;
use Ridgers\Grim\Domain\ClientConnectionInterface;
use Ridgers\Grim\Domain\Event;

class EventMatchingEventSendingService implements EventSendingService
{
    private $events;

    public function __construct()
    {
    }
    
    private function getEventsSentToClient(string $clientName)
    {
        foreach ($this->events as $event) {
            if ($clientName === $event['clientName']) {
                yield $event;
            }
        }
    }


    public function sendEvent(ClientConnectionInterface $client, Event $event)
    {
        $this->events[] = [
            'clientName' => $client->getClientName(),
            'event' => $event
        ];
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function matchingEventToClientShouldHaveBeenSent(string $clientName, Event $event)
    {
        $eventsSentToClient = $this->getEventsSentToClient($clientName);

        $callback = function ($haystack, $needle) {
            foreach ($haystack as $event) {
                if ($event['event'] == $needle) {
                    return true;
                }

                return false;
            }
        };
        
        \PHPUnit\Framework\Assert::assertTrue($callback($eventsSentToClient, $event));
    }
}
