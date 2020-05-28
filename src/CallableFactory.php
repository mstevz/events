<?php

namespace mstevz\Events;

abstract class CallableFactory {

    public static function fromObject(object $_obj, string $_method) {
        return function($e) use ($_obj, $_method){
                $_obj->{$_method}($e);
        };
    }

}

?>
