<?php

namespace mstevz\Events;

use \Psr\EventDispatcher\EventDispatcherInterface as IEventDispatcher;
use \Psr\EventDispatcher\ListenerProviderInterface as IListenerProvider;
use \mstevz\Events\Interfaces\IEventSubscriber;

class EventDispatcher implements IEventDispatcher {

    private $provider;

    public function __construct(IListenerProvider $_provider){
        $this->provider = $_provider;
    }

    public function dispatch(object $_event){
        $eventListeners = $this->provider->getListenersForEvent($_event);

        foreach($eventListeners as $listener){
            $listener($_event);
        }

        return $_event;
    }

}

?>
