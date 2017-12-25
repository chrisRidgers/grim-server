<?php
namespace Ridgers\Grim\Tests\Mocks;

use Ridgers\Grim\Domain\ClientConnectionPool;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\NullClientConnection;

class MockClientConnectionPool implements ClientConnectionPool
{
    public function __construct()
    {
        $this->clients = [];
    }

    public function attachClient(string $clientName)
    {
        $this->clients[] = $clientName;
    }

    public function getClients()
    {
        foreach ($this->clients as $client) {
            yield new NullClientConnection($client);
        }
    }

    public function getClient(string $clientName)
    {
        return new NullClientConnection($clientName);
    }
}
