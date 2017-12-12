<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\DummyClient;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\DummyEvent;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\SerialisedEventsMatchingServer;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\EventSendingServer;


/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $server;
    private $clients;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->server = new SerialisedEventsMatchingServer(
            new EventSendingServer()
        );
    }

    /**
     * @Given client :clientName is connected
     */
    public function clientIsConnected(string $clientName)
    {
        $this->clients[$clientName] = new DummyClient($this->server);
    }

    /**
     * @When client :clientName sends the event :eventName
     */
    public function clientSendsTheEvent(string $clientName, string $eventName)
    {
        $client = $this->clients[$clientName];
        $client->sendEvent(new DummyEvent($eventName));
    }

    /**
     * @Then client :clientName should have been sent the event :eventName
     */
    public function clientShouldHaveBeenSentTheEvent(string $clientName, string $eventName)
    {
        $this->server->eventMatchingEventShouldHaveBeenSent(new DummyEvent($clientName, $eventName));
    }
}
