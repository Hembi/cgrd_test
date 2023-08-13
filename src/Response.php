<?php

class Response
{
    public function __construct() {}

    public static function json($data, $http_code = 200)
    {
        header('Content-Type: application/json; charset=utf-8; http');
        http_response_code($http_code);
        echo json_encode($data);
        exit;
    }
}

?>