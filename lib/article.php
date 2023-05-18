<?php

class ArticleManager 
{
    private $connection;
    private $stmt;
    public function __construct()
    {
        $this->connection = new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
        $this->stmt = [
            "getAllArticle" => $this->connection->prepare(
                "SELECT * FROM `article` ORDER BY date LIMIT ?"
            ),
            "getSpecificArticle" => $this->connection->prepare(
                "SELECT * FROM `article` WHERE id = ?"
            ),
            "addSpecificArticle" => $this->connection->prepare(
                "INSERT INTO `article` (title, text, image, date) VALUES (?, ?, ?, ?)"
            ),
            "deleteSpecificArticle" => $this->connection->prepare(
                "DELETE FROM `article` WHERE id = ?"
            )
        ];
    }
    public function getAllArticle($limit)
    {
        $data = array();
        $this->stmt["getAllArticle"]->bind_param("s", $limit);
        $this->stmt["getAllArticle"]->execute();
        $query_result = $this->stmt["getAllArticle"]->get_result();
        
        while(true)
        {
            $article = $query_result->fetch_assoc();
            if(!$article)
                break;
            $article["admin"] = $this->isReadOnly();
            array_push($data, $article);
        };
        return $data;
    }
    public function isReadOnly() {
        return isset($_SESSION["admin"]) && $_SESSION["admin"];
    }
    public function getSpecificArticle($data) {
        $this->stmt["getSpecificArticle"]->bind_param("s", $data["id"]);
        $this->stmt["getSpecificArticle"]->execute();
        $query_result = $this->stmt["getSpecificArticle"]->get_result();
        return $query_result->fetch_assoc();
    }
    public function addSpecificArticle($data) {
        
        $title = $data["title"];
        $text = $data["text"];
        $image = $data["image"];
        $date = date('Y-m-d');
        $this->stmt["addSpecificArticle"]->bind_param("ssss", $title, $text, $image, $date);
        $this->stmt["addSpecificArticle"]->execute();
    }

    public function deleteSpecificArticle($data) {
        $id_file = $data["id"];
        $this->stmt["deleteSpecificArticle"]->bind_param("s", $id_file);
        $this->stmt["deleteSpecificArticle"]->execute();
    }

    public function moveImageToDir($file) 
    {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = ($this->getMaxNumName("image/articles") + 1).".".$ext;
        move_uploaded_file($file['tmp_name'], "image/articles/".$name);
        return $name;
    }
    private function getMaxNumName($dir)
    {
        $maxNum = 0;
        foreach (scandir($dir) as $key => $value)
        {
            $arr = preg_split("/\./",$value);
            $num = intval($arr[0]);
            if($maxNum < $num)
                $maxNum = $num;
        }
        return $maxNum;
    }
    public function __destruct() {
        foreach($this->stmt as $value)
            $value->close();
        $this->connection->close();
    }
}