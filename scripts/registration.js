let modalWindow = new ModalWindow(0, document.getElementById("win-container"));
document.querySelector("#registration_form").addEventListener("submit", e =>
{
    e.preventDefault();

    fetch('/action_registration', {
        method: 'POST',
        body: new URLSearchParams(new FormData(e.target)),
    })
    .then((responce) => responce.json())
    .then(responce => {
        if(responce.type === "failed")
        {
            let text = Object.values(responce.data).join('</br></br>');
            modalWindow.show("Помилка", text);
        }
        else
        {
            modalWindow.show("Повідомлення","успішно зареєстровано!");
            setTimeout(() => {window.location.assign("/");}, 2000);
        }
            
    })
    .catch(error => {
        console.log(error);
    });
});

