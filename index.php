<?php

include "autoload.php";

$router = new Router();

try {
    $router->get("/", "AppController::defaultPage", RouteType::UNSECURED);
    $router->get("/api/news", "NewsController@getList");
    $router->post("/api/news", "NewsController@create");
    $router->put("/api/news", "NewsController@update");
    $router->delete("/api/news", "NewsController@delete");
    $router->post("/api/login", "AuthController@login", RouteType::UNSECURED);
    $router->post("/api/logout", "AuthController@logout", RouteType::UNSECURED);

    $router->run();
}
catch(Exception $e)
{
    Response::json(["error" => $e->getMessage()], 500);
}

?>