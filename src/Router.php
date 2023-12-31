<?php

enum RouteType {
    case UNSECURED;
    case SECURED;
}

class Router {
    private $routes = [];
    
    function __construct() {}

    private function addRoute($method, $route, $handler, $secured)
    {
        if(empty($method))
            throw new Exception("Method can not be empty!");
        if(empty($route))
            throw new Exception("Route can not be empty!");
        if(empty($handler))
            throw new Exception("Handler can not be empty!");
        if(isset($this->routes[$method][$route]) && in_array($handler, $this->routes[$method][$route]))
            throw new Exception("Route already exists!");

        $this->routes[$method][$route] = [
            "secured" => $secured,
            "handler" => $handler
        ];
            
    }

    public function get($route, $handler, $secured = RouteType::SECURED)
    {
        $this->addRoute("GET", $route, $handler, $secured);
    }

    public function post($route, $handler, $secured = RouteType::SECURED)
    {
        $this->addRoute("POST", $route, $handler, $secured);
    }

    public function put($route, $handler, $secured = RouteType::SECURED)
    {
        $this->addRoute("PUT", $route, $handler, $secured);
    }

    public function delete($route, $handler, $secured = RouteType::SECURED)
    {
        $this->addRoute("DELETE", $route, $handler, $secured);
    }

    public function patch($route, $handler, $secured = RouteType::SECURED)
    {
        $this->addRoute("PATCH", $route, $handler, $secured);
    }

    public function validateRequest()
    {
        $authController = new AuthController();
        if(!empty($_REQUEST["token"]) && $authController->validateToken($_REQUEST["token"]))
        {
            return true;
        }
        else {
            Response::json(["error" => "Invalid Token", "data" => $_REQUEST], 401);
        }
    }

    function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
     }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (in_array($method, ['PUT', 'DELETE', 'PATCH'])) {
            $php_input = file_get_contents('php://input');
            if($this->isJson($php_input)) $requestData = json_decode($php_input, true);
            else parse_str($php_input, $requestData);
            $_REQUEST = array_merge($_REQUEST, $requestData);
        }

        $route    = explode('?', $_SERVER['REQUEST_URI'])[0] ?? "/";
        if (isset($this->routes[$method])) {
            if(isset($this->routes[$method][$route]) && isset($this->routes[$method][$route]["handler"]))
            {
                $handler = $this->routes[$method][$route]["handler"];

                /* Validate token */
                if(!empty($this->routes[$method][$route]["secured"]) && $this->routes[$method][$route]["secured"] == RouteType::SECURED)
                    $this->validateRequest();

                /* Call method handler */
                if(str_contains($handler, "@"))
                {
                    //Instance method
                    $handlerParts = explode("@", $handler);
                    $className = $handlerParts[0];
                    $methodName = $handlerParts[1];
                    if (method_exists($className, $methodName))
                    {
                        $ref = new $className;
                        $ref->{$methodName}();
                    }
                    else
                        throw new Exception('ERROR: Handler class method not implemented');
                }
                else if(str_contains($handler, "::"))
                {
                    //Static method
                    $handlerParts = explode("::", $handler);
                    $className = $handlerParts[0];
                    $methodName = $handlerParts[1];
                    if (method_exists($className, $methodName) && is_callable([$className, $methodName]))
                    {
                        call_user_func($handler);
                    }
                    else
                        throw new Exception('ERROR: Handler static method not implemented');
                }
                else
                    throw new Exception('ERROR: Route handler format not allowed'); 
            }
            else {
                throw new Exception('ERROR: Route does not exists');
            }
        }
        else
            throw new Exception('ERROR: Unkown HTTP method');
    }
}

?>