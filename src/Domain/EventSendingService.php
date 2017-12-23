<?php
namespace Ridgers\Grim\Domain;

interface EventSendingService {
    public function sendEvent(Client $client, Event $event);
}
