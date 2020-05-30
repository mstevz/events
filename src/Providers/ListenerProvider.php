<?php

namespace mstevz\Events\Providers;

use \Psr\EventDispatcher\ListenerProviderInterface as IListenerProvider;
use \Psr\Container\ContainerInterface as IContainer;

use \mstevz\collection\{ Dictionary, ArrayList };
use \mstevz\Events\CallableFactory;
use \mstevz\Events\Event;

/**
 * [ListenerProvider description]
 * @implements IListenerProvider
 */
class ListenerProvider implements IListenerProvider {

    /**
     * [private description]
     * @var Dictionary
     */
    private $container;

    private $currentId;
    private $comparisonId;
    private $lastListener;

    public function __construct() {
        $this->container = new Dictionary();

        $this->currentId = 0;
        $this->comparisonId = 0;
    }

    /**
     * Checks if listener is a closure or a class object.
     * @param  object $_listener [description]
     * @param  [type] $_handler  [description]
     * @return bool              [description]
     */
    private function isListenerClosure(object $_listener, string $_handler = null) : bool {

        $isMethodHandler = null;

        if(!is_callable($_listener) && !is_null($_handler)){
            // is object handler.
            $isMethodHandler = false;
        }
        else if(is_null($_handler)){
            // is closure.
            $isMethodHandler = true;
        }
        else{
            throw new \Exception("Error: No listener handler provided to \"{$_event}\".");
        }

        return $isMethodHandler;

    }

    private function getClassName(object $_value) : string {
        $eventFullNamespace = explode('\\', get_class($_value));
        return array_pop($eventFullNamespace);
    }

    public function registerEvent(object $_event) {

        $eventName = null;

        if($_event instanceof Event){
            // Spare reflection performance cost.
            $eventName = $_event->getName();
        }
        else{
            $eventName = $this->getClassName($_event);
        }

        if($this->container->offsetExists($eventName)){
            throw new Exception('An event with the same name has already been registered.');
        }

        $this->container->add($eventName, new ArrayList('object', false));
    }

    public function registerMultipleEvents(){
        $args    = func_get_args();
        $numArgs = func_num_args();

        if($numArgs > 15){
            throw new \Exception('');
        }

        foreach($args as $arg){
            $this->registerEvent($arg);
        }
    }

    /**
     * Sets listener ready to add to multiple events.
     * @param  object           $_listener [description]
     * @param  [type]           $_handler  [description]
     * @throws \Exception
     * @return ListenerProvider            [description]
     */
    public function addListener(object $_listener, string $_handler = null) : ListenerProvider {

        if($this->currentId != $this->comparisonId){
            throw new \Exception('Error: You must add previous listener to an event first.');
        }

        $this->lastListener = ($this->isListenerClosure($_listener, $_handler))
                            ? $_listener
                            : CallableFactory::fromObject($_listener, $_handler);

        $this->currentId++;

        return $this;
    }

    /**
     * Adds event listener to provided event.
     * @param  string           $_event [description]
     * @throws \Exception
     * @return ListenerProvider         [description
     */
    public function on(string $_event) : ListenerProvider {

        if(is_null($this->lastListener)){
            throw new \Exception('No listener provided.');
        }

        if(!$this->container->offsetExists($_event)){
            throw new \Exception("Error: Event \"${_event}\" does not exist or has not been registered.");
        }

        $this->comparisonId = $this->currentId;

        $this->container->get($_event)
                        ->add($this->lastListener);

        return $this;
    }

    public function getListenersForEvent(object $_event) : iterable {

        /*
         : WARNING :
         Event ID is currently working as EVENT CLASS OBJECT NAME.
         */

         $eventName = $_event->getName();

        $listeners = [];

        if($this->container->offsetExists($eventName)){
            $listeners = $this->container->get($eventName);
        }

        return $listeners;
    }

}

?>
