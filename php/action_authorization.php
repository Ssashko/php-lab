<?php

if(isset($_POST["action"]) && $_POST["action"] == "authorization")
{
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
}
else
    header("location: /p404");