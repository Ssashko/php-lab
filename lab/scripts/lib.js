class ModalWindow {
    constructor(id, container) {
        this.id = id;
        
        container.innerHTML = "<div id='modal_" + this.id + 
        "' class='modalWrapper'><div class='modalWindow'><p class='closeModal'>&#10006;</p><h1 class='modalTitle'>" + 
        "</h1><div class='modalText'>" + 
        "</div></div></div>";
        container.querySelector(".closeModal").addEventListener("click", e => {
            this.hide();
        });
        this.hide();
    }
    show(title, text)
    {
        document.getElementById("modal_" + this.id).querySelector(".modalTitle").innerHTML = title;
        document.getElementById("modal_" + this.id).querySelector(".modalText").innerHTML = text;
        document.getElementById("modal_" + this.id).style.display = "flex";
    }
    hide() {
        document.getElementById("modal_" + this.id).style.display = "none";
    }
}
