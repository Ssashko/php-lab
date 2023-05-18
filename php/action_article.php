<?php

$article_manager = new ArticleManager();

switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        {
            if(isset($_POST["final"]))
            {
                $article_manager->addSpecificArticle($_POST);
                jsonResponse(_JSON_OK_);
            }
            else
            {
                $image_name = $article_manager->moveImageToDir($_FILES["image"]);
                jsonResponse(_JSON_OK_, ["image_name" => $image_name]);
            }
        }
        break;
    case "GET":
        {
            if(isset($_GET["id"]))
                jsonResponse(_JSON_OK_, $article_manager->getSpecificArticle($_GET));
            jsonResponse(_JSON_FAILED_);
        }
        break;
    case "DELETE":
        {
            parse_str($_URL_PARAM, $_DELETE);
            $article_manager->deleteSpecificArticle($_DELETE);
            
            jsonResponse(_JSON_OK_);
        }
}