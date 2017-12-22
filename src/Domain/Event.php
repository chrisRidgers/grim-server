<?php
namespace Ridgers\Grim\Domain;

class Event implements EventInterface
{
    private $keys = [];
    private $data = [];

   public function __set($name, $value)
   {
       array_push($this->keys, $name);
       
       $this->data[$name] = $value;
   }
}
