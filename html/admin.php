<?php session_start();
include("fonctions.php");

// Sécurité : si pas connecté → redirection
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}
if($_SESSION["user"]["role"] != "admin"){
    echo "Accès refusé";
    exit;
}

$users = readData("json/utilisateurs.json");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration – Copa Cabanane 🍌</title>

    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php">Accueil</a>
        <a href="admin.php">Administration</a>
        <a href="index.php">Déconnexion</a>
    </nav>
</header>

<!-- ADMIN -->
<section>
    <h1>🛠️ Administration</h1>
    <p><b>Gestion des utilisateurs du site</b></p>
    <br><br>

    <!-- UTILISATEURS -->
    <div class="card">
        <h2>👥 Liste des utilisateurs</h2>

        <table width="100%" cellpadding="10">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
                <th>Statut</th>
            </tr>
            <?php foreach($users as $user){ ?>
            <tr>
                <td><nav><a href="profil.php?login=<?php echo $user["login"]; ?>"><?php echo $user["name"]; ?></a></nav></td>
                <td><?php echo $user["surname"]; ?></td>
                <td><?php echo $user["login"]; ?></td>
                <td><?php echo $user["role"]; ?></td>
                <td><nav><a href="modifier.php?login=<?php echo $user["login"]; ?>">✏️ Modifier</a> |
                <a href="supprimer.php?login=<?php echo $user["login"]; ?>"onclick="return confirm('Supprimer cet utilisateur ?')">🗑️ Supprimer</a></nav></td>
                <td><?php echo $user["statut"]; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</section>


<br><br><br><br><br><br>

<!-- FOOTER -->
<footer>
    © 2026 – Copa Cabanane 🍌
</footer>

</body>
</html>
