<?php session_start();
include("fonctions.php");
checkBlocked();

// Sécurité si utilisateur non connecté sinon redirection vers connexion
if(!isset($_SESSION["user"])){
    header("Location: connexion.php");
    exit;
}
//réserve les accès à la page aux admins uniquement
if($_SESSION["user"]["role"] != "admin"){
    echo "Accès refusé";
    exit;
}

// charger utilisateurs
$users = readData("json/utilisateurs.json");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration – Copa Cabanane 🍌</title>
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
    <link id="theme-style" rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Haut de page -->
<header class="header">
    <img src="images/logo-copa-cabanane.png" alt="Logo Copa Cabanane">
    <img src="https://static.vecteezy.com/system/resources/previews/031/122/692/non_2x/france-and-brazil-flags-two-flags-vector.jpg" alt="Drapeaux France et Brésil" style="height: 100px; margin-left: 20px; border-radius: 5px; width: 350px;">


    <nav>
        <a href="index.php">Accueil</a>
        <a href="admin.php">Administration</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>
</header>

<!-- partie admin -->
<section>
    <h1>🛠️ Administration</h1>
    <p><b>Gestion des utilisateurs du site</b></p>
    <br><br>

    <!-- tableau avec utilisateurs -->
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
                <th>Blocage</th>
            </tr>
            <?php foreach($users as $user){ ?>
            <tr>
                <!-- lien vers le profil de l'utilisateur -->
                <td><nav><a href="profil.php?login=<?php echo $user["login"]; ?>"><?php echo htmlspecialchars($user["name"]); ?></a></nav></td>
                <!-- affichage sécurisé des infos utilisateur-->
                <td><?php echo htmlspecialchars($user["surname"]); ?></td>
                <td><?php echo htmlspecialchars($user["login"]); ?></td>
                <td><?php echo htmlspecialchars($user["role"]); ?></td>

                <!-- liens vers les pages de modification et suppression de l'utilisateur -->
                <td><nav><a href="modifier.php?login=<?php echo $user["login"]; ?>">✏️ Modifier</a> |
                <a href="supprimer.php?login=<?php echo $user["login"]; ?>"
                    onclick="return confirm('Supprimer cet utilisateur ?')">🗑️ Supprimer</a></nav></td>
                <!-- affichage du statut de l'utilisateur (actif ou bloqué) -->    
                <td><?php echo $user["statut"] ?? "actif"; ?></td>
                <!-- bouton de blocage/déblocage de l'utilisateur-->
                <td><button class="block-btn" data-login="<?php echo $user["login"]; ?>" data-blocked="<?php echo (isset($user["blocked"]) && $user["blocked"]) ? '1' : '0'; ?>">
                     <?php echo (isset($user["blocked"]) && $user["blocked"]) ? "Débloquer": "Bloquer"; ?>
                </button></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</section>


<br><br><br><br><br><br>

<!-- bas de page -->
<footer>
    © 2026 – Copa Cabanane 🍌
</footer>

<script src="js/theme.js"></script>
<script src="js/block.js"></script>
</body>
</html>
