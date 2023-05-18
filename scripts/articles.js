
let modalWindow = new ModalWindow(0, document.getElementById("win-container"));

document.querySelector("#addArticleWindow > .closeModal").addEventListener("click", function(){
    let window = document.getElementById("addArticleWindow").parentElement;
    hideBlock(window);
});
let container = document.querySelector(".article-container");
let article = new Article(container);
article.loadArticles();

document.querySelector('.article-container').addEventListener('scroll', event => {
    const {scrollHeight, scrollTop, clientHeight} = event.target;

    if (Math.abs(scrollHeight - clientHeight - scrollTop) < 1) {
        article.addArticles()
    }
});

document.querySelector("#addArticleWindow > form").addEventListener("submit", async function(e){
    e.preventDefault();

    let title = document.getElementById("add-article-title").value;
    let text = document.getElementById("add-article-text").value;
    let image = document.getElementById("add-article-image").files[0];
    await article.addArticle(image, title, text);
    article.loadArticles();
    hideBlock(document.querySelector("#addArticleWindow").parentElement);
});
document.querySelector(".article-container").addEventListener("click",async function(e){
    let target = e.target.closest(".article-delete-button");
    if(!target) return;

    let id = target.dataset.id;
    await article.deleteArticle(id);
    article.loadArticles();
});
try{
document.querySelector(".article-add-button").addEventListener("click", function(){
    let window = document.getElementById("addArticleWindow").parentElement;
    showBlock(window);
});
}
catch(e){};
