function abreNav() {
    const sideNav = document.getElementById("sideNav");

    sideNav.classList.remove("navCerrado");
    sideNav.classList.add("navAbierto");

    sideNav.focus();

    document.getElementById("botonAbreNav").style.opacity = "0";

    const overlay = document.getElementById("overlay");

    overlay.style.opacity = "0.9";
    overlay.style.pointerEvents = "auto";

    overlay.style.width = "100vw";
    overlay.style.height = "100vh";
    
}

function cierraNav() {
    const sideNav = document.getElementById("sideNav");

    sideNav.classList.remove("navAbierto");
    sideNav.classList.add("navCerrado");
    
    sideNav.blur();

    document.getElementById("botonAbreNav").style.opacity = "1";

    const overlay = document.getElementById("overlay");

    overlay.style.opacity = "0";
    overlay.style.pointerEvents = "none";

    setTimeout(() => {
        if (document.activeElement.id != "sideNav") {
            overlay.style.width = "0";
            overlay.style.height = "0";
        }   
    }, 750);

}