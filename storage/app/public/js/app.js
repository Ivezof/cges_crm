window.onload = () => {
    console.log(window.document)
    let burger_btn = document.getElementById('bm');
    let nav_menu = document.getElementById('nav_panel');
    let nav_item = document.getElementsByClassName('nav-active')[0];
    let menu_status = Number(localStorage.getItem('menu_status'));
    burger_btn.onclick = () => {
        change_burger()
    }
    console.log(localStorage.getItem('menu_status'))
    initBurger()
    console.log('menu_status: ', menu_status)

    function change_burger () {
        if (menu_status === 0) {
            nav_menu.style.animation=""
            nav_item.style.animation=''
            nav_menu.classList.add('short');
            menu_status++;
            console.log('new status: ', menu_status)
            localStorage.setItem('menu_status', String(menu_status))
        } else if (menu_status === 1) {
            nav_menu.classList.remove('short');
            menu_status--;
            console.log('new status: ', menu_status)
            localStorage.setItem('menu_status', String(menu_status))
            nav_menu.style.animation="long 1s forwards ease-in-out"
            nav_item.style.animation='long 1s forwards ease-in-out'
        }
    }

    function initBurger() {
        if (menu_status === 1) {
            nav_menu.style.animation=""
            nav_item.style.animation=''
            nav_menu.classList.add('short');
        } else if (menu_status === 0) {
            nav_menu.style.animation=""
            nav_item.style.animation=''
            nav_menu.classList.remove('short');
        }
    }
}

function GetURLParameter(sParam)
{
    const sPageURL = window.location.search.substring(1);
    const sURLVariables = sPageURL.split('&');
    for (let i = 0; i < sURLVariables.length; i++)
    {
        const sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam)
        {
            return sParameterName[1];
        }
    }
}

