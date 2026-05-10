const form = document.getElementById("formulaire-inscription");

const email = document.getElementById("login");

const phone = document.getElementById("phone");

const password = document.getElementById("password");

const passwordCounter = document.getElementById("password-counter");



/* ŒIL MOT DE PASSE */
function togglePassword() {

    password.type =
        password.type === "password"
            ? "text"
            : "password";
}



/* COMPTEUR */
password.addEventListener("input", () => {

    passwordCounter.textContent =
        password.value.length + "/20 caractères";
});



/* VALIDATION */
form.addEventListener("submit", function(event) {

    let valid = true;



    /* RESET */
    document.getElementById("login-error").textContent = "";
    document.getElementById("phone-error").textContent = "";
    document.getElementById("password-error").textContent = "";



    /* EMAIL */
    const emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email.value)) {

        document.getElementById("login-error")
            .textContent = "Email invalide";

        valid = false;
    }



    /* TELEPHONE */
    const phonePattern =
        /^0[0-9]{9}$/;

    if (!phonePattern.test(phone.value.replace(/\s/g, ""))) {

        document.getElementById("phone-error")
            .textContent = "Téléphone invalide";

        valid = false;
    }



    /* MOT DE PASSE */
    if (password.value.length < 6) {

        document.getElementById("password-error")
            .textContent =
            "Le mot de passe doit contenir au moins 6 caractères";

        valid = false;
    }



    /* BLOQUE ENVOI */
    if (!valid) {

        event.preventDefault();
    }

});