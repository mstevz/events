<?php

namespace mstevz\Events;

use \Psr\EventDispatcher\StoppableEventInterface as IStoppableEvent;

/**
 * [Event description]
 * @implements IStoppableEvent
 */
class Event implements IStoppableEvent {

    protected $name;
    protected $value;

    public function __construct(string $_name = null) {
        $this->name = ($_name) ?? $this->getDefaultName();
    }

    private function getDefaultName(){
        $eventFullNamespace = explode('\\', get_class($this));
        return array_pop($eventFullNamespace);
    }


    public function getName() : string {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function isPropagationStopped() : bool {
        throw new \Exception();
    }
}

?>
