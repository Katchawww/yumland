const profileForm = document.getElementById("form-profil");

profileForm.addEventListener("submit", function(event) {

    /* empêche reload */
    event.preventDefault();

    /* récupère données */
    const formData = new FormData(profileForm);



    fetch("profil.php", {
        method: "POST",
        body: formData
    })

    .then(response => response.text())

    .then(data => {

        if(data === "success") {
    
            document.getElementById("profil-success")
                .textContent = "✅ Profil mis à jour !";
    
        } else {
    
            document.getElementById("profil-success")
                .textContent = "❌ Erreur lors de la modification";
        }
    })

    .catch(error => {

        document.getElementById("profil-success")
            .textContent = "❌ Erreur";
    });

});