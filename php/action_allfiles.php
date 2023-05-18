<?php
$file_accessor = new FileAccessor();

jsonResponse(_JSON_OK_, $file_accessor->getAllFiles(isset($_GET["specific_owner"]) ? $_SESSION["id"] : null));