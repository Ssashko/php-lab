<?php


class FileAccessor 
{
    private $connection;
    private $stmt;
    private $user_info;
    public function __construct($auth = false, $id = null, $admin = null)
    {
        $this->user_info["auth"] = $auth;
        $this->user_info["id"] = $id;
        $this->user_info["admin"] = $admin;
        $this->connection = new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);
        $this->stmt = [
            "addfile" => $this->connection->prepare(
                "INSERT INTO `file` (name, text, image, path, owner) VALUES (?, ?, ?, ?, ?)"
            ),
            "updatefile" => $this->connection->prepare(
                "UPDATE `file` SET name = ?, text = ? WHERE id = ?"
            ),
            "deletefile" => $this->connection->prepare(
                "DELETE FROM `file` WHERE id = ?"
            ),
            "getfile" => $this->connection->prepare(
                "SELECT * FROM `file` WHERE id = ?"
            ),
            "getOwner" => $this->connection->prepare(
                "SELECT `owner` FROM `file` WHERE id = ?"
            ),
            "getOwnerLogin" => $this->connection->prepare(
                "SELECT `login` FROM `user` WHERE id = ?"
            ),
        ];
    }
    public function getAllFiles($id = null)
    {
        $data = array();

        if(is_null($id))
            $query_result = $this->connection->query("SELECT id, name, image, owner, path FROM `file`");
        else
            $query_result = $this->connection->query("SELECT id, name, image, owner, path FROM `file` WHERE owner = ". $id);
        
        while(true)
        {
            $file = $query_result->fetch_assoc();
            if(!$file)
                break;
            $file["readonly"] = $this->isReadOnlyById($file["owner"]) ? "true" : "false";

            $this->stmt["getOwnerLogin"]->bind_param("s", $file["owner"]);
            $this->stmt["getOwnerLogin"]->execute();
            $file["owner"] = $this->stmt["getOwnerLogin"]->get_result()->fetch_assoc()["login"];

            array_push($data, $file);
        };
        return $data;
    }
    public function isReadOnlyFile($file_id) {
        $this->stmt["getOwner"]->bind_param("s", $file_id);
        $this->stmt["getOwner"]->execute();
        $ownerId = $this->stmt["getOwner"]->get_result()->fetch_assoc()["owner"];
        return $this->isReadOnlyById($ownerId);
    }
    public function isReadOnlyById($ownerId) {
        return !($this->isUser() && ($ownerId == $this->user_info["id"] || $this->user_info["admin"]));
    }
    public function isUser()
    {
        return isset($this->user_info["auth"]);
    }
    public function addFile($name, $text, $image, $path) {
        $this->stmt["addfile"]->bind_param("sssss", $name, $text, $image, $path, $this->user_info["id"]); 
        $this->stmt["addfile"]->execute();
    }
    public function updateFile($id, $name, $text) {
        
        $this->stmt["updatefile"]->bind_param("sss", $name, $text, $id);
        $this->stmt["updatefile"]->execute();
    }

    public function deleteFile($id_file) {
        $this->stmt["deletefile"]->bind_param("s", $id_file);
        $this->stmt["deletefile"]->execute();
    }
    public function getFile($id_file) {
        $this->stmt["getfile"]->bind_param("s", $id_file);
        $this->stmt["getfile"]->execute();
        $file = $this->stmt["getfile"]->get_result()->fetch_assoc();

        $this->stmt["getOwnerLogin"]->bind_param("s", $file["owner"]);
        $this->stmt["getOwnerLogin"]->execute();
        $file["owner"] = $this->stmt["getOwnerLogin"]->get_result()->fetch_assoc()["login"];

        return $file;
    } 
    public function moveFileToDir($file) 
    {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = ($this->getMaxNumName("files")+1).".".$ext;
        move_uploaded_file($file['tmp_name'], "files"."/".$name);
        return $name;
    }
    public function moveImageToDir($file) 
    {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = ($this->getMaxNumName("image/files")+1).".".$ext;
        move_uploaded_file($file['tmp_name'], "image/files/".$name);
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