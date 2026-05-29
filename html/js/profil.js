//récupère le formulaire de profil
const profileForm = document.getElementById("form-profil");
//ajoute un écouteur d'événement pour la soumission du formulaire
profileForm.addEventListener("submit", function(event) {

    // empêche reload de la page 
    event.preventDefault();

    // récupère données du formulaire
    const formData = new FormData(profileForm);

    // envoie les données du formulaire au serveur via une requête POST
    fetch("profil.php", {
        method: "POST",
        body: formData
    })

    // attend la réponse du serveur et la convertit en texte
    .then(response => response.text())
    .then(data => {
        // met à jour le message de succès ou d'erreur en fonction de la réponse du serveur
        if(data === "success") {
            document.getElementById("profil-success")
                .textContent = "✅ Profil mis à jour !";
    
        } else {
            document.getElementById("profil-success")
                .textContent = "❌ Erreur lors de la modification";
        }
    })

    // gère les erreurs de la requête
    .catch(error => {
        document.getElementById("profil-success")
            .textContent = "❌ Erreur";
    });
});