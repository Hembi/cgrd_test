<?php

class Autoloader
{
    function __construct()
    {
        spl_autoload_register( function($class) {
            $path = $_SERVER['DOCUMENT_ROOT'] . '/src/';
            require_once  $path . $class .'.php';
        });
    }
}
new Autoloader();

?>