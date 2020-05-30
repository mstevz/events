<?php

namespace mstevz\Events;

use \mstevz\Events\Event;
use \mstevz\Events\EventDispatcher;
use \mstevz\Events\Providers\ListenerProvider;

class Eventful {

    // private $events;
    public $listeners;
    private $dispatcher;

    public function __construct() {
        $this->listeners = new ListenerProvider();
        $this->dispatcher = new EventDispatcher($this->listeners);
    }

    public function registerEvent(object $event) {
        $this->listeners->registerEvent($event);
    }

    public function addListener(object $_listener, string $_handler, string $_event){
        $this->listeners->addListener($_listener, $_handler)
                        ->on($_event);
    }

    public function dispatch(object $event) {
        $this->dispatcher->dispatch($event);
    }

}

?>
