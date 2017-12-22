<?php
namespace Ridgers\Grim\Infrastructure\ServerProxiesEvents;

use Ridgers\Grim\Domain\Event;

class EventFactory
{
    public static function createEventFromJsonEvent(string $eventDetails)
    {
        $eventDetails = json_decode($eventDetails, true);
        $eventDetailsKeys = array_keys($eventDetails);

        $eventDetailsKeys = array_map(
            function ($key) {
                $keyWords = explode('-', $key);
                $keyWords = array_map(
                    function ($keyWord) {
                        return ucfirst($keyWord);
                    },
                    $keyWords
                );
                return lcfirst(implode('', $keyWords));
            },
            $eventDetailsKeys
        );

        $eventDetails = array_combine($eventDetailsKeys, $eventDetails);

        $event = new Event();

        array_walk($eventDetails, function ($eventDetail, $eventDetailKey) use ($event) {
            $event->__set($eventDetailKey, $eventDetail);
        });

        return $event;
    }
}

