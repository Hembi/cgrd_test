<?php

class AppController
{
    function __construct()
    {
        
    }

    static function defaultPage()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/public" . "/index.html";
    }
}

?>