<?php

$file_accessor = isset($_SESSION["auth"]) ? new FileAccessor($_SESSION["auth"], $_SESSION["id"], $_SESSION["admin"]) : new FileAccessor();

$id = validate_text($_GET["id_file"]);
$info = $file_accessor->getFile($id);
$file = "files"."/".$info["path"];

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
else
    header("location: /p404");