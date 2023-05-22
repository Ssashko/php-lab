<?php

$article_manager = isset($_SESSION["auth"]) ? new ArticleManager($_SESSION["auth"], $_SESSION["id"], $_SESSION["admin"]) : new ArticleManager();

$count = isset($_GET["count"]) ? intval($_GET["count"]) : 10;
jsonResponse(_JSON_OK_, $article_manager->getAllArticle($count));