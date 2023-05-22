<?php
$file_accessor = isset($_SESSION["auth"]) ? new FileAccessor($_SESSION["auth"], $_SESSION["id"], $_SESSION["admin"]) : new FileAccessor();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        {
            if(isset($_POST["final"]))
            {
                if($file_accessor->isUser())
                {
                    $name = validate_text($_POST["name"]);
                    $text = validate_text($_POST["text"]);
                    $image = validate_url($_POST["image"]);
                    $path = validate_url($_POST["path"]);
                    $file_accessor->addFile($name, $text, $image, $path);
                    jsonResponse(_JSON_OK_);
                }
                else
                    jsonResponse(_JSON_FAILED_);
            }
            else
            {
                if($file_accessor->isUser())
                {
                    $image_name = $file_accessor->moveImageToDir($_FILES["image"]);
                    $file_name = $file_accessor->moveFileToDir($_FILES["file"]);
                    jsonResponse(_JSON_OK_, 
                        ["image_name" => $image_name, "file_name" => $file_name]
                    );
                }
                else
                    jsonResponse(_JSON_FAILED_);
            }
        }
        break;
    case "PUT":
        {
            parse_str(file_get_contents('php://input'), $_PUT);
            $id = validate_text($_PUT["id"]);
            $name = validate_text($_PUT["name"]);
            $text = validate_text($_PUT["text"]);
            if($file_accessor->isReadOnlyFile($id))
                jsonResponse(_JSON_FAILED_);
            else
            {
                $file_accessor->updateFile($id, $name, $text);
                jsonResponse(_JSON_OK_);
            }
        }
        break;
    case "GET":
        {
            $id = validate_text($_GET["id_file"]);
            if(isset($id))
                jsonResponse(_JSON_OK_, $file_accessor->getFile($id));
            jsonResponse(_JSON_FAILED_);
        }
        break;
    case "DELETE":
        {
            parse_str($_URL_PARAM, $_DELETE);
            $id = validate_text($_DELETE["id_file"]);
            if($file_accessor->isReadOnlyFile($id))
                jsonResponse(_JSON_FAILED_);
            else
            {
                $file_accessor->deleteFile($id);
                jsonResponse(_JSON_OK_);
            }
        }
}