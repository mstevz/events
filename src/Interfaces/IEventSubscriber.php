<?php

namespace mstevz\Events\Interfaces;

interface IEventSubscriber {
    public function eventHandler(object $event);
}

?>
