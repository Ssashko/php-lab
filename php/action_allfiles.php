<?php
$file_accessor = isset($_SESSION["auth"]) ? new FileAccessor($_SESSION["auth"], $_SESSION["id"], $_SESSION["admin"]) : new FileAccessor();

jsonResponse(_JSON_OK_, $file_accessor->getAllFiles(isset($_GET["specific_owner"]) ? $_SESSION["id"] : null));