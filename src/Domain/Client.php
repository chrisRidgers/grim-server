<?php
namespace Ridgers\Grim\Domain;

interface Client
{
    public function sendEvent(Event $event);
}
