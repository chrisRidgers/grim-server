<?php
namespace Ridgers\Grim\Tests\Mocks;

use Ridgers\Grim\Domain\ClientConnectionPool;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\DummyClient;

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
            yield new DummyClient($client);
        }
    }

    public function getClient(string $clientName)
    {
        return new DummyClient($clientName);
    }
}
