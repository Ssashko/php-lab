<script src="/scripts/lib.js"></script>
<main>
    <div class="displayNone modalWrapperWindow">
        <div class="modalWindowExtended" id="addArticleWindow">
            <p class='closeModal'>&#10006;</p>
            <h1>Додати статтю</h1>
            <form action="">
                <label for="add-article-title">Назва файла:</label><br>
                <input required type="text" id="add-article-title" class="file-title" placeholder="назва"><br>
                <label  for="add-article-text">Опис статті:</label><br>
                <textarea required id="add-article-text" class="file-text" cols="30" rows="10"></textarea><br>
                <label for="add-file-image">Завантажити фото:</label><br>
                <input required type="file" name="image" id="add-article-image" class="file-image" accept="image/png, image/jpeg"><br>
                <input type="submit">
            </form>
        </div>
    </div>
    <div class="article-controller">
        <h1>Список статей</h1>
        <?php
            if(hasAdminRight())
                include("layout/button_article.php");
        ?>
    </div>
    <div class="article-container">
    </div>
    <div class="displayNone loading">
        <img src="image/loading.gif" >
    </div>

</main>
<script src="/scripts/articles.js" defer></script>