<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\ClientConnectionInterface;
use Ridgers\Grim\Domain\Event;
use Ridgers\Grim\Domain\Server;

class NullClientConnection implements ClientConnectionInterface
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
