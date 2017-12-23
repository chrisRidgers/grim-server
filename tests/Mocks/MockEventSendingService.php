<?php
namespace Ridgers\Grim\Mocks;

class MockEventSendingService implements EventSendingService
{
    private $eventSendingService;

    public function __construct(EventSendingService $eventSendingService)
    {
        $this->eventSendingService = $eventSendingService;
    }
    
    public function sendEvent(Client $client, Event $event)
    {
        $this->eventSendingService->send($client, $event);
    }
}
