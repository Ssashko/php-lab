<?php
session_start();
require_once("lib.php");
if ( $_SERVER['REQUEST_URI'] == '/') $page = 'home';
else {
    $page = substr($_SERVER['REQUEST_URI'],1);
    if (!preg_match('/^[A-z0-9]{3,20}$/', $page)){
     require_once 'view/p404.php';
     exit;
    };
};

require_once("config.php");

if ( file_exists('view/'.$page.'.php')) {

    $title = $config[$page]["title"];
    $style = $config[$page]["style"];
    require_once("layout/header.php"); 
    require_once("layout/leftbar.php"); 
    require_once 'view/'.$page.'.php';
    require_once("layout/footer.php");
}
else if (file_exists('php/'.$page.'.php')) require_once 'php/'.$page.'.php';
else
{
    $title = $config["p404"]["title"];
    $style = $config["p404"]["style"];
    require_once("layout/header.php"); 
    require_once("layout/leftbar.php"); 
    require_once 'view/p404.php';
    require_once("layout/footer.php");
}
    
