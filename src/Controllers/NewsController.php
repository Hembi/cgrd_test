<?php

class NewsController
{
    function __construct()
    {
        
    }

    function getList()
    {
        $news = new News();
        $newsList = $news->fetchAll();
        Response::json($newsList);
    }

    function create()
    {
        if(!empty($_POST["title"]) && !empty($_POST["description"]))
        {
            $news = new News();
            $id = $news->create($_POST["title"], $_POST["description"]);
            Response::json(["id" => $id]);
        }
        else
        {
            Response::json(["error" => "Title and description are required"], 400);
        }
    }

    function update()
    {
        if(!empty($_REQUEST["id"]) && !empty($_REQUEST["title"]) && !empty($_REQUEST["description"]))
        {
            $news = new News();
            $ok = $news->update($_REQUEST["id"], $_REQUEST["title"], $_REQUEST["description"]);
            Response::json($ok);
        }
        else
        {
            Response::json(["error" => "ID, title and description are required"], 400);
        }
    }

    function delete()
    {
        if(!empty($_REQUEST["id"]))
        {
            $news = new News();
            $newsList = $news->delete($_REQUEST["id"]);
            Response::json($newsList);
        }
        else
        {
            Response::json(["error" => "ID is required"], 400);
        }
    }
}

?>