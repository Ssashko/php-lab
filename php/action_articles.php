<?php

$article_manager = new ArticleManager();
$count = isset($_GET["count"]) ? intval($_GET["count"]) : 10;
jsonResponse(_JSON_OK_, $article_manager->getAllArticle($count));