<?php 

    $article_manager = new ArticleManager();
    if(!isset($_GET["id"]))
        header("location: /p404");
    $info = $article_manager->getSpecificArticle($_GET);    