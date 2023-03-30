<?php
if ( $_SERVER['REQUEST_URI'] == '/') $page = 'home';
else {
    $page = substr($_SERVER['REQUEST_URI'],1);
    if (!preg_match('/^[A-z0-9]{3,20}$/', $page)){
     include_once 'view/p404.php';
     exit;
    };
};

if ( file_exists('view/'.$page.'.php')) include_once 'view/'.$page.'.php';
else if (file_exists('view/'.$page.'.php')) include_once 'view/'.$page.'.php';
else {
    include_once 'view/p404.php';
    exit;
};