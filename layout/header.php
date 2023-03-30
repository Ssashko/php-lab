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
            <div class="button-set">
                <button>Вхід</button>
                <button>Реєстрація</button>
            </div>
        </header>
        <div class="inner-wrapper">