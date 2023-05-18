<main>
    <div class="article-image-wrapper">
        <img src="image/articles/<?=strtolower($info["image"])?>" alt="">
    </div>
    <div class="article-wrapper-title">
        <h1 class="article-header"><?=$info["title"]?></h1>
        <p class="article-date"><?=$info["date"]?></p>
    </div>
    <p class="article-id">id : <?=$info["id"]?></p>
    <p class="article-text"><?=$info["text"]?></p>
</main>