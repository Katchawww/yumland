<?php session_start();
include("fonctions.php");

// on traite le formulaire d'inscription
if(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["name"])){

    // on charge les utilisateurs existants
    $users = readData("json/utilisateurs.json");

    // on crée un nouvel utilisateur avec les données du formulaire
    $newUser = [
        "id" => count($users)+1,
        "login" => $_POST["login"],
        "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
        "role" => "client",
        "name" => $_POST["name"],
        "surname" => $_POST["surname"],
        "phone" => $_POST["phone"],
        "address" => $_POST["address"]
    ];
    // on ajoute le nouvel utilisateur à la liste des utilisateurs
    $users[] = $newUser;

    // nettoyage et validation des données
    $login = trim($_POST["login"]);
    $name = htmlspecialchars(trim($_POST["name"]));
    $surname = htmlspecialchars(trim($_POST["surname"]));

    // on verifie si email valide et si téléphone valide
    if(!filter_var($login, FILTER_VALIDATE_EMAIL)){
        die("Email invalide");
    }

    if(!preg_match("/^[0-9 ]{8,15}$/", $_POST["phone"])){
        die("Téléphone invalide");
    }


    // Sauvegarde des données dans JSON
    saveData("json/utilisateurs.json", $users);
    // Suppression du token CSRF de la session
    unset($_SESSION['csrf']);

    // on redirige vers la page de connexion après inscription
    header("Location: connexion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription – Copa Cabanane 🍌</title>
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Haut de page -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php">Accueil</a>
        <a href="produits.php">Plats</a>
        <a href="inscription.php">Inscription</a>
        <a href="connexion.php">Connexion</a>
    </nav>
</header>

<section>
    <h1>📝 Inscription</h1>
    <p>Créez votre compte pour commander plus rapidement</p>
    <!-- Formulaire d'inscription -->
    <form class="form" method="POST" action="inscription.php" id="formulaire-inscription">
        <input type="hidden" name="csrf" value="<?php echo generateCSRF(); ?>">
        <label>Nom</label>
        <input type="text" placeholder="Votre nom" name="name" required>

        <label>Prénom</label>
        <input type="text" placeholder="Votre prénom" name="surname" required>

        <label>Email</label>
        <input type="email" placeholder="exemple@mail.com" name="login" id="login" required>
        <p class="error" id="login-error"></p>

        <label>Téléphone</label>
        <input type="tel" placeholder="06 12 34 56 78" name="phone" id="phone" required>
        <p class="error" id="phone-error"></p>

        <label>Adresse</label>
        <input type="text" placeholder="Adresse complète" name="address" required>

        <label>Mot de passe</label>
        <div class="password-container">
            <input type="password" placeholder="Mot de passe" name="password" id="password" maxlength="20" required>

        <!-- Bouton pour afficher/masquer le mot de passe -->
        <button type="button" onclick="togglePassword()">👁️</button>
        </div>

        <!-- Compteur de caractères pour le mot de passe -->
        <p id="password-counter">0/20 caractères</p>
        <p class="error" id="password-error"></p>

        <button type="submit">S'inscrire</button>
        <nav><p style="text-align:center; margin-top:15px;">
            Déja inscrit ?
            <a href="connexion.php">Se connecter</a></nav>
        </p>
    </form>
</section>

<!-- bas de page -->
<footer>
    © 2026 – Copa Cabanane 🍌
    <nav>
        <p>Contact:
        <a href="mailto:contactcopacabanane@gmail.com">📧 contactcopacabanane@gmail.com</a>
        | <a href="https://www.instagram.com"> Instagram</a>
         | <a href="https://www.tiktok.com/fr/">Tiktok</a></p> 
    </nav>  
</footer>

<script src="js/theme.js"></script>
<script src="js/validation.js"></script>
</body>
</html>
