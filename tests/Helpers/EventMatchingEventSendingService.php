<?php
namespace Ridgers\Grim\Tests\Helpers;

use Ridgers\Grim\Domain\EventSendingService;
use Ridgers\Grim\Domain\Client;
use Ridgers\Grim\Domain\Event;

class EventMatchingEventSendingService implements EventSendingService
{
    private $eventSendingService;

    public function __construct(EventSendingService $service)
    {
        $this->eventSendingService = $service;

    }

    public function sendEvent(Client $client, Event $event)
    {
        $this->eventSendingService->sendEvent($client, $event);
    }

    public function matchingEventToClientShouldHaveBeenSent(Event $event, Iterable $events)
    {
        $callback = function($haystack, $needle) {
            foreach ($haystack as $event) {
                if ($event['event'] == $needle) {
                    return true;
                }

                return false;
            }
        };
        
        \PHPUnit\Framework\Assert::assertTrue($callback($events, $event)); 
    }
}
