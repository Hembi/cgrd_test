<?php

include "autoload.php";

$router = new Router();

$router->get("/", "AppController::defaultPage", RouteType::UNSECURED);
$router->get("/api/news", "NewsController@getList");
$router->post("/api/news", "NewsController@create");
$router->put("/api/news", "NewsController@update");
$router->delete("/api/news", "NewsController@delete");
$router->delete("/api/login", "LoginController@login");

$router->run();

?>