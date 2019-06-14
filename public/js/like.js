// STRICT MODE
"use strict";


function onClickBtnLike(e)
{
    e.preventDefault();

    //---CONST DECLARATION
    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icon = this.querySelector('i');

    //---AJAX REQUEST
    axios.get(url).then(function(response){
        spanCount.textContent = response.data.likes;

        if(icon.classList.contains('fas'))
        {
            icon.classList.replace('fas', 'far');
        }else
        {
            icon.classList.replace('far', 'fas');
        }
    }).catch(function (error){
        if(error.response.status === 403)
        {
            alert("Connectez vous pour liker...");
        } else
        {
            alert("Une erreur s'est produite, réessayez plus tard svp...");
        }
    })
}
//---ADD EVENT LISTENER
document.querySelectorAll('a.js-like').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike);
});
