<?php session_start(); ?>

<?php
if(isset($_SESSION['user_id'])){
    echo '<a href="index.php">Accueil</a>';
    echo '<a href="produits.php">Plats</a>';
    echo '<a href="profil.php">Mon profil</a>';
    echo '<a href="deconnexion.php">Deconnexion</a>';
}else{
    echo '<a href="index.php">Accueil</a>';
    echo '<a href="produits.php">Plats</a>';
    echo '<a href=connexion.php">Connexion</a>';
    echo '<a href="inscription.php">Inscription</a>';
    }
?>

  
    
    
