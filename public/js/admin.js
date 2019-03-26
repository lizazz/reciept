window.onload = function() {
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    watchMenu();
};

function watchMenu() {
    let isHideMenu = getCookie('showmenu');
    let link = $(".sidebar-toggle")[0];
    if(isHideMenu == 1) {
        link = $(".sidebar-toggle")[0];
        if(link != undefined) {
            link.click();
        }
    }

    $(link).on('click', function () {
        if(isHideMenu != 1) {
            document.cookie = "showmenu=1";
        }else{
            document.cookie = "showmenu=0";
        }
    })
}

// возвращает cookie с именем name, если есть, если нет, то undefined
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}