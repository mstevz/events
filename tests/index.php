<?php

require_once './../vendor/autoload.php';

use \mstevz\Events\Event;
use \mstevz\Events\EventDispatcher;
use \mstevz\Events\Providers\ListenerProvider;
use \mstevz\Events\Interfaces\IEventSubscriber;

class Reporter {

    private $listeners;
    private $newsDispatcher;


    public function __construct(){
        $this->listeners = new ListenerProvider();
        $this->newsDispatcher = new EventDispatcher($this->listeners);
        $this->listeners->registerEvent(new Event('news'));
    }

    public function getSubscribed(object $listener, $handler){
        $this->listeners->addListener($listener, $handler)
                        ->on('news');
    }

    public function write(){
        echo "<pre>";
        $this->newsDispatcher->dispatch(new Event('news'));

        var_dump($this->newsDispatcher);
        echo "</pre>";
    }

}

class TVStation {

    private $name;

    public function __construct(string $name){
            $this->name = $name;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getNewsEvent(object $e){
        echo "ok";
        var_dump($e);
    }
}



$john = new Reporter();
$doe  = new Reporter();

$chan1 = new TVStation('chan1');
$chan2 = new TVStation('chan2');

$john->getSubscribed($chan1, 'getNewsEvent');
$doe->getSubscribed($chan2, 'getNewsEvent');

$john->write();











?>
