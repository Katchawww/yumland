



function setCookie(name, value, days) {
    let expires = "";

    if (days) {
        const date = new Date();

        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

        expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + value + expires + "; path=/";
}


function getCookie(name) {

    const nameEQ = name + "=";

    const cookies = document.cookie.split(';');

    for (let i = 0; i < cookies.length; i++) {

        let c = cookies[i];

        while (c.charAt(0) === ' ') {
            c = c.substring(1, c.length);
        }

        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }

    return null;
}



function toggleTheme() {

    const theme = document.getElementById("theme-style");

    if (theme.getAttribute("href") === "css/style.css") {

        theme.setAttribute("href", "css/dark.css");

        setCookie("theme", "dark", 30);

    } else {

        theme.setAttribute("href", "css/style.css");

        setCookie("theme", "light", 30);
    }
}

/* Vérifie le cookie au chargement */
window.onload = function () {

    const savedTheme = getCookie("theme");

    if (savedTheme === "dark") {

        document
            .getElementById("theme-style")
            .setAttribute("href", "css/dark.css");
    }
}