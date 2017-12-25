<?php
namespace Ridgers\Grim\Domain;

interface EventSendingService
{
    public function sendEvent(ClientConnectionInterface $client, Event $event);
}
