<?php

include "autoload.php";

$router = new Router();

$router->get("/api/news", "News::getList");

?>