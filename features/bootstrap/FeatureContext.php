<?php
namespace Ridgers\Grim\Tests\Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
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
    private $server;

    /**
     * @var mixed
     */
    private $eventMatchingEventSendingService;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $mockClientConnectionPool = new MockClientConnectionPool();
        $this->eventMatchingEventSendingService =
            new EventMatchingEventSendingService();

        $eventSendingServer = new EventSendingServer(
            $mockClientConnectionPool,
            $this->eventMatchingEventSendingService
        );
        $this->server = new EventsMatchingServer($eventSendingServer);
    }

    /**
     * @Given client :clientName is connected
     */
    public function clientIsConnected(string $clientName)
    {
        $this->server->attachClient($clientName);
    }

    /**
     * @When the server receives the event:
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function serverReceivesTheEvent(TableNode $eventDetails)
    {
        $event = EventFactory::createEventFromJsonEvent(
            \Ridgers\Grim\Tests\Helpers\Transformer::tableNodeToJsonEvent($eventDetails)
        );

        $this->server->receiveEvent($event);
    }

    /**
     * @Then client :clientName should have been sent the event:
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function clientShouldHaveBeenSentTheEvent(string $clientName, TableNode $eventDetails)
    {
        $event = EventFactory::createEventFromJsonEvent(
            \Ridgers\Grim\Tests\Helpers\Transformer::tableNodeToJsonEvent($eventDetails)
        );

        $this->eventMatchingEventSendingService->matchingEventToClientShouldHaveBeenSent($clientName, $event);
    }
}
