<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\DummyClient;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\DummyEvent;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\EventsMatchingServer;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\EventSendingServer;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\EventFactory;
use Ridgers\Grim\Tests\Helpers\Transformer;
use Ridgers\Grim\Tests\Mocks\MockClientConnectionPool;
use Ridgers\Grim\Tests\Helpers\EventMatchingEventSendingService;
use Ridgers\Grim\Infrastructure\ServerProxiesEvents\LoggingEventSendingService;


/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $eventSendingServer;
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
        $this->clientConnectionPool = new MockClientConnectionPool();
        $this->loggingEventSendingService = new LoggingEventSendingService();
        $this->eventMatchingEventSendingService = new EventMatchingEventSendingService($this->loggingEventSendingService);

        $this->eventSendingServer = new EventSendingServer(
            $this->clientConnectionPool,
            $this->eventMatchingEventSendingService
        );
        $this->server = new EventsMatchingServer($this->eventSendingServer);
    }

    /**
     * @Given client :clientName is connected
     */
    public function clientIsConnected(string $clientName)
    {
        $this->clientConnectionPool->attachClient($clientName);
    }

    /**
     * @When client :clientName sends the event :eventName with the details:
     */
    public function clientSendsTheEvent(string $clientName, string $eventName, TableNode $eventDetails)
    {
        $event = EventFactory::createEventFromJsonEvent(
            \Ridgers\Grim\Tests\Helpers\Transformer::tableNodeToJsonEvent($eventDetails)
        );

        $this->server->receiveEvent($clientName, $event);
    }

    /**
     * @Then client :clientName should have been sent the event:
     */
    public function clientShouldHaveBeenSentTheEvent(string $clientName, TableNode $eventDetails)
    {
        $event = EventFactory::createEventFromJsonEvent(
            \Ridgers\Grim\Tests\Helpers\Transformer::tableNodeToJsonEvent($eventDetails)
        );

        $client = $this->clientConnectionPool->getClient($clientName);
        $eventsSentToClient = $this->loggingEventSendingService->getEventsSentToClient($client);

        $this->eventMatchingEventSendingService->matchingEventToClientShouldHaveBeenSent($event, $eventsSentToClient);
    }
}
