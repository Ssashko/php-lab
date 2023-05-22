<?php

$article_manager = isset($_SESSION["auth"]) ? new ArticleManager($_SESSION["auth"], $_SESSION["id"], $_SESSION["admin"]) : new ArticleManager();

switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        {
            if(isset($_POST["final"]))
            {
                if($article_manager->isReadOnly())
                    jsonResponse(_JSON_FAILED_);
                else
                {
                    $title = validate_text($_POST["title"]);
                    $text = validate_text($_POST["text"]);
                    $image = validate_url($_POST["image"]);
                    $article_manager->addSpecificArticle($title, $text, $image);
                    jsonResponse(_JSON_OK_);
                }
            }
            else
            {
                if($article_manager->isReadOnly())
                    jsonResponse(_JSON_FAILED_);
                else
                {
                    $image_name = $article_manager->moveImageToDir($_FILES["image"]);
                    jsonResponse(_JSON_OK_, ["image_name" => $image_name]);
                }
            }
        }
        break;
    case "GET":
        {
            
            if(isset($_GET["id"]))
                jsonResponse(_JSON_OK_, $article_manager->getSpecificArticle(validate_text($_GET["id"])));
            jsonResponse(_JSON_FAILED_);
        }
        break;
    case "DELETE":
        {
            parse_str($_URL_PARAM, $_DELETE);
            if($article_manager->isReadOnly())
                jsonResponse(_JSON_FAILED_);
            else
            {
                $id = validate_text($_DELETE["id"]);
                $article_manager->deleteSpecificArticle($id);
                jsonResponse(_JSON_OK_);
            }
        }
}