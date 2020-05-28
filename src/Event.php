<?php

namespace mstevz\Events;

use \Psr\EventDispatcher\StoppableEventInterface as IStoppableEvent;

/**
 * [Event description]
 * @implements IStoppableEvent
 */
class Event implements IStoppableEvent {

    private $name;

    public function __construct(string $_name) {
        $this->name = $_name;
    }

    public function getName() : string {
        return $this->name;
    }

    public function isPropagationStopped() : bool {
        throw new \Exception();
    }
}

?>
