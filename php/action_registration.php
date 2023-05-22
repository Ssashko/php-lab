<?php
if(isset($_POST["action"]) && $_POST["action"] == "registration")
{
    $registration = new Registration($_POST);

    $registration->validate_fields();

    if($registration->has_error())
        jsonResponse(_JSON_FAILED_, $registration->getErrors());
    else
    {
        $registration->exec();
        if($registration->has_error())
            jsonResponse(_JSON_FAILED_, $registration->getErrors());
        else
        {
            $registration->auth();
            jsonResponse(_JSON_OK_, array());
        }
    }
}
else 
    header("location: /p404");  