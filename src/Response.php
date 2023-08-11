<?php

class Response
{
    public function __construct() {}

    public static function json($data, $http_code = 200)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, $http_code);
        exit;
    }
}

?>