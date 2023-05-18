<div class="user-info">
    <p><span>логін : </span><?=$_SESSION["login"]?></p>
    <p><span>електронна пошта : </span><?=$_SESSION["email"]?></p>
    <p><span>тип облікового запису : </span><?=$_SESSION["admin"] ? "адмін" : "користувач"?></p>
</div>