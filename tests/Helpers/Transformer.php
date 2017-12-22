<?php
namespace Ridgers\Grim\Tests\Helpers;

use Behat\Gherkin\Node\TableNode;

class Transformer
{ 
    public static function stringToClassName(string $eventName)
    {
        $noneLetterRegexPattern = '/\W/';
        $eventName = explode(' ', trim(preg_replace($noneLetterRegexPattern, ' ', $eventName)));

        $eventName = array_map(
            function ($word) {
                return ucfirst(strtolower($word));
            },
            $eventName
        );
        
        return implode('', $eventName);
    }

    public static function tableNodeToJsonEvent(TableNode $eventDetails)
    {
        $eventDetails = $eventDetails->getColumnsHash();

        $eventDetailsKeys = array_keys($eventDetails);
        $eventDetailsKeys = array_map(
            function ($key) {
                return trim(strtolower(preg_replace('/\W/', '-', $key)));
            },
            $eventDetailsKeys
        );

        $eventDetails = array_combine($eventDetailsKeys, $eventDetails);

        return json_encode($eventDetails);
    }
}
