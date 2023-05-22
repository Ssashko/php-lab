let modalWindow = new ModalWindow(0, document.getElementById("win-container"));
let fileEntryContainer = document.querySelector(".file-entry-container");
let fileAccessor = new FileAccessor(fileEntryContainer, modalWindow);
let updateFileWindow = document.getElementById("updateFileWindow");
let addFileWindow = document.getElementById("addFileWindow");
let getFileWindow = document.getElementById("getFileWindow");

addFileWindow.querySelector("form").addEventListener("submit",async function(e) {
    e.preventDefault();
    await fileAccessor.createFile(
        addFileWindow.querySelector(".file-title"),
        addFileWindow.querySelector(".file-text"),
        addFileWindow.querySelector(".file-resource"),
        addFileWindow.querySelector(".file-image")
        );
    closeAllWindow();
    fileAccessor.update();
});
updateFileWindow.querySelector("form").addEventListener("submit",async function(e) {
    e.preventDefault();
    await fileAccessor.updateFile(
        document.getElementById("update-file-id").value,
        updateFileWindow.querySelector(".file-title"),
        updateFileWindow.querySelector(".file-text")
        );
    closeAllWindow();
    fileAccessor.update();
});

function closeAllWindow() {

    let updateFileWindow = document.getElementById("updateFileWindow");
    let addFileWindow = document.getElementById("addFileWindow");
    let getFileWindow = document.getElementById("getFileWindow");
    hideBlock(addFileWindow.parentElement);
    hideBlock(updateFileWindow.parentElement);
    hideBlock(getFileWindow.parentElement);

}

addFileWindow.querySelector(".closeModal").addEventListener("click", function(e){
    hideBlock(addFileWindow.parentElement);
});
updateFileWindow.querySelector(".closeModal").addEventListener("click", function(e){
    hideBlock(updateFileWindow.parentElement);
});
getFileWindow.querySelector(".closeModal").addEventListener("click", function(e){
    hideBlock(getFileWindow.parentElement);
});
document.querySelector(".file-entry-editor-create").addEventListener("click", function(e){
    showBlock(addFileWindow.parentElement);
});

document.querySelector(".switch-file").addEventListener("click", function(e){
    let target = e.target.closest("input[name='switch-file-owner']");
    if(!target) return;
    fileAccessor.update(target.value != "all");
});