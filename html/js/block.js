// selectionner tous les boutons de blocage
const buttons = document.querySelectorAll(".block-btn");

// ajouter un écouteur d'événement à chaque bouton
buttons.forEach(button => {
    button.addEventListener("click", async function() {

        // récupérer le login de l'utilisateur à bloquer/débloquer
        const login = this.dataset.login;

        //requete vers le serveur pour bloquer/débloquer l'utilisateur
        const response = await fetch(
            "block_user.php",
            {
                method: "POST",
                // envoi les données encodées comme un formulaire classique
                headers: {
                    "Content-Type":
                    "application/x-www-form-urlencoded"
                },
                // envoyer le login de l'utilisateur à bloquer/débloquer
                body: "login=" + login
            }
        );
        // attendre la réponse du serveur et la convertir en texte
        const data = await response.text();

        // mettre à jour le texte du bouton et son état de blocage en fonction de la réponse du serveur
        if(data === "blocked") {
            this.textContent = "Débloquer";
            this.dataset.blocked = "1";
        }
        else {
            this.textContent = "Bloquer";
            this.dataset.blocked = "0";
        }
    });
});