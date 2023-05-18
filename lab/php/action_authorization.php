<?php

$authorization = new Autorization($_POST);

$authorization->validate_fields();

if($authorization->has_error())
    jsonResponse(_JSON_FAILED_, $authorization->getErrors());
else
{
    $authorization->exec();
    if($authorization->has_error())
        jsonResponse(_JSON_FAILED_, $authorization->getErrors());
    else
    {
        $authorization->auth();
        jsonResponse(_JSON_OK_, array());
    }
}

