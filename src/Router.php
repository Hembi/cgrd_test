<?php

class Router {
    private $routes = [];
    
    function __construct() {}

    private function addRoute($method, $route, $handler)
    {
        if(empty($method))      throw new Exception("Method can not be empty!");
        if(empty($route))       throw new Exception("Route can not be empty!");
        if(empty($handler))     throw new Exception("Handler can not be empty!");
        if(isset($this->routes[$method][$route]) && in_array($handler, $this->routes[$method][$route])) throw new Exception("Route already exists!");

        $this->routes[$method][$route] = $handler;
            
    }

    public function get($route, $handler)
    {
        $this->addRoute("GET", $route, $handler);
    }

    public function post($route, $handler)
    {
        $this->addRoute("POST", $route, $handler);
    }

    public function update($route, $handler)
    {
        $this->addRoute("UPDATE", $route, $handler);
    }

    public function delete($route, $handler)
    {
        $this->addRoute("DELETE", $route, $handler);
    }

    public function put($route, $handler)
    {
        $this->addRoute("PUT", $route, $handler);
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url    = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $handler) {
                if ($routeUrl === $url) {
                    call_user_func($handler);
                }
            }
        }
        throw new Exception('Route not found');
    }
}

?>