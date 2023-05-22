class ModalWindow {
    constructor(id, container, type = "standart") {
        this.id = id;
        
        container.innerHTML += "<div id='modal_" + this.id + 
        "' class='modalWrapper'><div class='"+
        (type == "standart" ? "modalWindow" : "modalWindowExtended" )
        +"'><p class='closeModal'>&#10006;</p><h1 class='modalTitle'>" + 
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
async function UploadFile (file, action)
{
	const form = new FormData();
	form.append('file', file);
	let url;
	return fetch(action,{method : "POST", body : form}).then(response => response.json())
	.then(responce => {
		if(responce.type == "error")
			return null;
		else
			return responce.url;
	});
}
function showBlock(block) {
    block.classList.remove("displayNone");
}
function hideBlock(block) {
    block.classList.add("displayNone");
}
class FileAccessor {
    constructor(container, modalWindow) {
        this.container = container;
        this.modalWindow = modalWindow;
        this.update();
        this.eventInit();
    }
    
    async update(specific_owner = false) {
        let param = '';
        if(specific_owner)
            param = '?specific_owner=true';
        await fetch('/action_allfiles'+param)
        .then((responce) => responce.json())
        .then(responce => {
            let res = "";
            responce.data.forEach(element => {
                res += '<div class="file-entry" data-id="' + element.id + '">\
                <div class="file-entry-wrapper">\
                <img class="file-entry-image" src="/image/files/'+ element.image +'">\
                </div>\
                <h1 class="file-entry-title">'+ element.name +'</h1>\
                <a class="file-entry-resource" href="/action_getfile?id_file=' + element.id + '">Завантажити</a>\
                <p class="file-entry-owner">' + element.owner + '</p>\
                <div class="file-entry-editor">\
                    <button class="file-entry-editor-get">Отримати додаткові відомості</button>\
                    ' +
                    (element.readonly == "false" ? '\
                    <button class="file-entry-editor-update">Оновити файл</button>\
                    <button class="file-entry-editor-delete">Видалити файл</button>\
                    ' 
                    : '') +
                    '\
                </div>\
            </div>\
                ';
            });
            this.container.innerHTML = (res == "" ? "Немає файлів" : res);
                
        }) 
        .catch(error => {
            console.log(error);
        });

        
    }
    async eventInit() {
        this.container.addEventListener("click", (e) => {
            let target = e.target.closest(".file-entry-editor-update");
            if(!target) return;
            let id = target.parentElement.parentElement.dataset.id;
            let updateFileWindow = document.getElementById("updateFileWindow");
            document.getElementById("update-file-id").value = id;
            showBlock(updateFileWindow.parentElement);
        });
        this.container.addEventListener("click", (e) => {
            let target = e.target.closest(".file-entry-editor-get");
            if(!target) return;
            let id = target.parentElement.parentElement.dataset.id;
            let getFileWindow = document.getElementById("getFileWindow");
            this.getFile(id, getFileWindow);
            showBlock(getFileWindow.parentElement);
        });
        this.container.addEventListener("click", (e) => {
            let target = e.target.closest(".file-entry-editor-delete");
            if(!target) return;
            let id = target.parentElement.parentElement.dataset.id;
            this.deleteFile(id);
            this.update();
        });
    }
    async getFile(id, container)
    {  
        let data = await fetch('/action_files?id_file=' + id)
        .then((responce) => responce.json())
        .then((responce) => responce.data)
        .catch(error => {
            console.log(error);
        });
        showBlock(container);
        container.querySelector(".file-image").src = "/image/files/" + data.image;
        container.querySelector(".file-title").innerHTML = data.name;
        container.querySelector(".file-text").innerHTML = data.text;
        container.querySelector(".file-resource").href = "/action_getfile?id_file=" + data.id;
        container.querySelector(".file-owner").innerHTML = data.owner;
        container.querySelector(".closeModal")
    }

    async deleteFile(id)
    {
        await fetch('/action_files?id_file=' + id, {
            method: 'DELETE',
          })
        .then((responce) => responce.json())
        .then((responce) =>{
            this.modalWindow.show("Повідомлення", "запис видалено");
        })
        .catch(error => {
            console.log(error);
        });
    }
    async updateFile(id, name, text)
    {
        const form = new FormData();
        form.append('id', id);
	    form.append('name', name.value);
        form.append('text', text.value);
        console.log(name);
        await fetch('/action_files', {
            method: 'PUT',
            body: new URLSearchParams(form)
          })
        .then((responce) => responce.json())
        .then((responce) =>{
            this.modalWindow.show("Повідомлення", "запис оновлено");
        })
        .catch(error => {
            console.log(error);
        });
    }
    async createFile(name, text, file, image)
    {
        const form1 = new FormData();
	    form1.append('file', file.files[0]);
        form1.append('image', image.files[0]);
        let files_name = await fetch('/action_files', {
            method: 'POST',
            body: form1
          })
        .then((responce) => responce.json())
        .then((responce) =>{
            return responce.data
        })
        .catch(error => {
            console.log(error);
        });
        const form2 = new FormData();
        form2.append('path', files_name.file_name);
        form2.append('image', files_name.image_name);
        form2.append('name', name.value);
        form2.append('text', text.value);
        form2.append('final', "true");
        fetch('/action_files', {
            method: 'POST',
            body: new URLSearchParams(form2)
          })
        .then((responce) => responce.json())
        .then((responce) =>{
            this.modalWindow.show("Повідомлення", "файл додано");
        })
        .catch(error => {
            console.log(error);
        });
    }

}

class Article 
{
    constructor(container)
    {
        this.container = container;
        this.limit = 5;
    }
    getArticleHTML(image, title, data, id, admin)
    {
        return `\
        <article>\
            <div class="article-image-wrapper">\
                <img src="image/articles/${image}" alt="">\
            </div>\
            <div class="article-control">\
                <h1 class="article-title">${title}</h1>\
                <p class="article-date">${data}</p>\
            </div>\
            <div class="article-id-wrapper">\
                <p>id:<span class="article-id-val">${id}</span></p>\
            </div>\
            <button class="article-detail-button"><a href="/article?id=${id}">Детальніше</a></button>`
            + (admin ? `<button data-id="${id}" class="article-delete-button">Видалити</button>` : "") +
        `</article>`;
    }
    async addArticle(image, title, text)
    {
        const form1 = new FormData();
        form1.append('image', image);
        let file_name = await fetch('/action_article', {
            method: 'POST',
            body: form1
          })
        .then((responce) => responce.json())
        .then((responce) =>{
            return responce.data.image_name
        })
        .catch(error => {
            console.log(error);
        });

        const form2 = new FormData();
        form2.append('image', file_name);
        form2.append('title', title);
        form2.append('text', text);
        form2.append('final', "true");
        fetch('/action_article', {
            method: 'POST',
            body: new URLSearchParams(form2)
          })
        .then((responce) => responce.json())
        .then((responce) =>{
            modalWindow.show("Повідомлення", "Стаття додана");
        })
        .catch(error => {
            console.log(error);
        });
    }
    addArticles()
    {
        showLoading();
        this.limit += 5;
        setTimeout(async () =>  this.loadArticles(), 500);
    }
    async loadArticles()
    {
        await fetch('/action_articles?count='+this.limit)
        .then((responce) => responce.json())
        .then((responce) =>{
            let res = "";
            responce.data.forEach(el => {
                res += this.getArticleHTML(el.image, el.title, el.date, el.id, el.admin);
            });
            hideLoading();
            this.container.innerHTML = (res == "" ? "Блог порожній" : res);
        })
        .catch(error => {
            console.log(error);
        });
    }
    async deleteArticle(id)
    {
        await fetch('/action_article?id=' + id, {
            method: 'DELETE',
          })
        .then((responce) => responce.json())
        .then((responce) =>{
            modalWindow.show("Повідомлення", "Стаття видалена");
        })
        .catch(error => {
            console.log(error);
        });
    }
    
}

function showLoading() {
    showBlock(document.querySelector(".loading"));
}
function hideLoading() {
    hideBlock(document.querySelector(".loading"));
}