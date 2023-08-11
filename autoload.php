<?php

class Autoloader
{
    function __construct()
    {
        spl_autoload_register( function($class) {
            $root_path = $_SERVER['DOCUMENT_ROOT'];
            $config_dir = '/config/';
            $src_dir = '/src/';
            $controllers_dir = '/Controllers/';
            $models_dir = '/Models/';
            if(is_file($root_path . $config_dir . $class .'.php'))
                require_once $root_path . $config_dir . $class .'.php';
            else if(is_file($root_path . $src_dir . $class .'.php'))
                require_once $root_path . $src_dir . $class .'.php';
            else if(is_file($root_path . $src_dir . $controllers_dir . $class .'.php'))
                require_once $root_path . $src_dir . $controllers_dir . $class .'.php';
            else if(is_file($root_path . $src_dir . $models_dir . $class .'.php'))
                require_once $root_path . $src_dir . $models_dir . $class .'.php';
            else
                throw new Exception("Error: No class found with name {$class}.");
        });
    }
}
new Autoloader();

?>