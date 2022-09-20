const THEMES = {
    "pink": {
        "--colorMainGradiente": "rgb(255, 153, 230)",
        "--colorHoverBoton": "rgb(235, 5, 85)",

        "--colorBotonTarjetas": "rgb(210, 77, 255)",
        "--colorFondoHeaderTarjeta": "rgb(230, 0, 172)",

        "--colorFondoBotonNavegar": "#222",

        "--colorFondoBotonBusqueda-RGB": "235, 5, 85",

        "--colorFondoBotonNuevo-RGB": "235, 5, 85",

        "--colorFondoForm": "#ddd",
        "--colorBordesForm": "#aaa"
    }
}

function updateThemes(theme) {
    const style = document.querySelector("html").style;

    for (const cssvar in THEMES[theme]) {
        style.setProperty(cssvar, THEMES[theme][cssvar], "important");
    }

    document.documentElement.style.backgroundColor = THEMES[theme]["--colorMainGradiente"];
}

localStorage.setItem("theme", "pink");

const theme = localStorage.getItem("theme");

if (theme) {
    updateThemes(theme);
}
    




