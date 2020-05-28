<?php

require_once './../vendor/autoload.php';

use \mstevz\Events\Event;
use \mstevz\Events\EventDispatcher;
use \mstevz\Events\Providers\ListenerProvider;
use \mstevz\Events\Interfaces\IEventSubscriber;


interface ServiceProvider {

        public function getService(string $service);

        public function getAllServices() : iterable;

}

class Auth {

    private $services;

    public function __construct(){
        $this->services = get_class_methods($this);
    }

    public function login(){
        //handle
    }

    public function register(){

    }
}

var_dump(ProviderFactory::fromObjectMethods(new Auth));
















?>
