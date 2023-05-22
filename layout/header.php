<!DOCTYPE HTML>
<html>
<head>
    <title><?=$title?></title>
    <meta charset="utf-8">
    <link href="/styles/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="icon" href="/image/logo.ico">
    <?= isset($style) ? '<link rel="stylesheet" href="/styles/'.$style.'.css">' : '';?>
    <script defer src="/scripts/script.js"></script>
</head>
<body>
    <div class="wrapper">
        <header>
            <img class="header-logo" src="/image/logo.png">
            <?php
            if(isset($_SESSION['auth']))
            {
                include("user_info.php");
                include("button_set_user.php");    
            }
            else
                include("button_set_guest.php");    
            ?>
    
        </header>
        <div class="inner-wrapper">