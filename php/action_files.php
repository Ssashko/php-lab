<?php
$file_accessor = new FileAccessor();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        {
            if(isset($_POST["final"]))
            {
                $file_accessor->addFile($_POST);
                jsonResponse(_JSON_OK_);
            }
            else
            {
                $image_name = $file_accessor->moveImageToDir($_FILES["image"]);
                $file_name = $file_accessor->moveFileToDir($_FILES["file"]);
                jsonResponse(_JSON_OK_, 
                    ["image_name" => $image_name, "file_name" => $file_name]
                );
            }
        }
        break;
    case "PUT":
        {
            parse_str(file_get_contents('php://input'), $_PUT);
            $file_accessor->updateFile($_PUT);
            jsonResponse(_JSON_OK_);
        }
        break;
    case "GET":
        {
            if(isset($_GET["id_file"]))
                jsonResponse(_JSON_OK_, $file_accessor->getFile($_GET));
            jsonResponse(_JSON_FAILED_);
        }
        break;
    case "DELETE":
        {
            parse_str($_URL_PARAM, $_DELETE);
            $file_accessor->deleteFile($_DELETE);
            
            jsonResponse(_JSON_OK_);
        }
}