<?php
function password_validate($pass) {
    return preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-z0-9_-]{7,30}$/', $pass);
}
function login_validate($login) {
	return preg_match('/^[A-z0-9_-]{4,30}$/', $login);
}
function email_validate($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
} 
function captha_validate($captcha) {
    $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret=' . RECAPTHCA_SECRET_KEY . '&response=' . $captcha);
    $response = curl_exec($curl);
	curl_close($curl);
    $responseKeys = json_decode($response);
    return $responseKeys->success;
}

define("_JSON_OK_", "ok");
define("_JSON_FAILED_", "failed");

function jsonResponse($ok, $data = array()) {
    header('Content-Type: application/json; charset=utf-8');
    exit('{"type":"'.$ok.'","data":'.json_encode($data).'}');
}

function authorized_required()
{
    if(!isset($_SESSION["auth"]))
        header("location: /p404");
}
function authorized_forbitten()
{
    if(isset($_SESSION["auth"]))
        header("location: /p404");
}

function hasAdminRight()
{
    return isset($_SESSION["admin"]) && $_SESSION["admin"];
}

require_once("lib/auth.php");
require_once("lib/file.php");
require_once("lib/article.php");
require_once("lib/validator.php");
?>