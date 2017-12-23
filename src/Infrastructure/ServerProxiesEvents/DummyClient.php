<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Client;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Server;

class DummyClient implements Client
{
    private $clientName;

    public function __construct(string $clientName)
    {
        $this->clientName = $clientName;
    }

    public function getClientName()
    {
        return $this->clientName;
    }
}
