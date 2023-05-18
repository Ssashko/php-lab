<script src="/scripts/lib.js"></script>
<main>
    <div class="displayNone modalWrapperWindow">
        <div class="modalWindowExtended" id="addFileWindow">
            <p class='closeModal'>&#10006;</p>
            <h1>Додати файл</h1>
            <form action="">
                <label for="add-file-title">Назва файла:</label><br>
                <input required type="text" id="add-file-title" class="file-title" placeholder="назва"><br>
                <label  for="add-file-text">Опис файла:</label><br>
                <input required type="text" id="add-file-text" class="file-text" placeholder="опис"><br>
                <label for="add-file-image">Завантажити фото:</label><br>
                <input required type="file" name="image" id="add-file-image" class="file-image" accept="image/png, image/jpeg"><br>
                <label for="add-file-resource">Завантажити файл:</label><br>
                <input required type="file" name="file" id="add-file-resource" class="file-resource"><br>
                <input type="submit">
            </form>
        </div>
    </div>
    <div class="displayNone modalWrapperWindow">
        <div class="modalWindowExtended" id="updateFileWindow">
            <p class='closeModal'>&#10006;</p>
            <h1>Оновити файл</h1>
            <form action="">
                <label for="update-file-title">Назва файла:</label><br>
                <input required type="text" id="update-file-title" class="file-title" placeholder="назва"><br>
                <label for="update-file-text">Опис файла:</label><br>
                <input required type="text" id="update-file-text" class="file-text" placeholder="опис"><br>
                <input required type="hidden" id="update-file-id" value="<id>"><br>
                <input type="submit">
            </form>
        </div> 
    </div>
    <div class="displayNone modalWrapperWindow">
        <div class="modalWindowExtended" id="getFileWindow">
            <h1>Інформація про файл</h1>
            <p class='closeModal'>&#10006;</p><br>
            <img class="file-image" src="/image/files/0.png"><br>
            <h1 class="file-title">Назва</h1><br>
            <p class="file-text">Текст</p><br>
            <a class="file-resource" href="/action_getfile">Завантажити</a><br>
            <p class="file-owner">Власник</p>
        </div> 
    </div> 
    <div class="file-controller">
        <h1>Список файлів</h1>
        <?php
        if(isset($_SESSION['auth']))
            include("layout/file_control_set.php");
        ?>
    </div>
    <div class="file-entry-container">
        
    </div>
</main>
<script src="/scripts/file.js" defer></script>