//récupère les éléments du formulaire d'inscription
const form = document.getElementById("formulaire-inscription");
const email = document.getElementById("login");
const phone = document.getElementById("phone");
const password = document.getElementById("password");
const passwordCounter = document.getElementById("password-counter");

// fonction pour afficher/masquer mdp
function togglePassword() {
    password.type =
        password.type === "password" ? "text" : "password";
}

// Compteur mis a jour 
password.addEventListener("input", () => {
    passwordCounter.textContent =
        password.value.length + "/20 caractères";
});

// Validation du formulaire avant envoi
form.addEventListener("submit", function(event) {
    // variable pour suivre la validité du formulaire
    let valid = true;

    // efface les messages d'erreur précédents
    document.getElementById("login-error").textContent = "";
    document.getElementById("phone-error").textContent = "";
    document.getElementById("password-error").textContent = "";

    // vérification du format de l'email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email.value)) {
        document.getElementById("login-error").textContent = "Email invalide";
        valid = false;
    }

    // vérification du format du téléphone (10 chiffres commençant par 0)
    const phonePattern = /^0[0-9]{9}$/;
    // on enlève les espaces du numéro de téléphone avant de le tester
    if (!phonePattern.test(phone.value.replace(/\s/g, ""))) {
        document.getElementById("phone-error").textContent = "Téléphone invalide";
        valid = false;
    }

    // vérification de la longueur du mot de passe (au moins 6 caractères)
    if (password.value.length < 6) {
        document.getElementById("password-error").textContent ="Le mot de passe doit contenir au moins 6 caractères";
        valid = false;
    }

    // si le formulaire n'est pas valide, on empêche son envoi
    if (!valid) {
        event.preventDefault();
    }
});