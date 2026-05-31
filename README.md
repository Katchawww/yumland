# 🍌 Copa Cabanane

Copa Cabanane est une application web de restauration inspirée des saveurs du Brésil, envie d'un bain de soleil ? Plongez dans l'univers culinaire de ce pays magique.  
Les clients sont rois, ils peuvent consulter les produits, passer commande, payer en ligne et suivre leurs commandes et une fonctionnalité caché se trouve sur le site à vous de jouer!

---

#  Fonctionnalités

##  Gestion des utilisateurs

- Inscription
- Connexion / Déconnexion
- Gestion du profil
- Système de rôles :
  - Client
  - Livreur
  - Restaurateur
  - Administrateur
- Blocage / déblocage des comptes

##  Gestion des produits

- Consultation des plats et menus
- Recherche par nom
- Filtrage par catégorie
- Tri :
  - Prix croissant
  - Prix décroissant
  - Ordre alphabétique
- Filtrage par allergènes

##  Panier

- Ajout de produits
- Ajout de menus
- Suppression d'articles
- Gestion des quantités
- Calcul automatique du total

##  Fidélité

- Gestion des remises :
  - 5 %
  - 10 %
- Application automatique lors de la validation d'une commande

##  Paiement

- Intégration de CyBank
- Génération sécurisée des transactions
- Signature de contrôle

##  Commandes

- Validation de commande
- Historique des commandes
- Modification d'une commande payée
- Attribution d'un livreur
- Suivi du statut :
  - En attente de paiement
  - Payée
  - Préparation
  - Prête
  - En livraison
  - Terminée

##  Livraison

- Interface dédiée aux livreurs
- Consultation des commandes attribuées
- Mise à jour des statuts

##  Personnalisation

- Mode clair
- Mode sombre
- Sauvegarde du thème via cookies

##  Banana Mode

Mode bonus permettant :

- L'apparition de bananes animées
- Un mini-jeu "Attrape les bananes"
- Un compteur de score

---

#  Sécurité

Le projet intègre plusieurs mécanismes de sécurité :

- Protection CSRF
- Vérification des sessions
- Contrôle des rôles
- Vérification des comptes bloqués
- Validation des formulaires côté client
- Validation des données côté serveur

---

#  Structure du projet

```
/
├── css/
│   ├── style.css
│   └── dark.css
│
├── js/
│   ├── tri.js
│   ├── theme.js
│   ├── block.js
│   ├── validation.js
│   ├── profil.js
│   └── fun.js
│
├── json/
│   ├── utilisateurs.json
│   ├── plats.json
│   ├── menus.json
│   ├── commandes.json
│   └── livreurs.json
│
├── images/
│
├── index.php
├── produits.php
├── panier.php
├── valider.php
├── connexion.php
├── inscription.php
├── profil.php
├── admin.php
├── restauration.php
├── deconnexion.php
├── etatcommandes.php
├── commandes.php
├── block_user.php
├── modifier_commande.php
├── paiement_modification.php
├── retour_modification.php
├── livraison.php
├── avis.php
├── modifier.php
├── supprimer.php
├── livrer.php
├── getapikey.php
├── retour.php
├── restauration.php
└── fonctions.php
```

---

# Technologies utilisées

- PHP
- HTML
- CSS
- JavaScript
- JSON
- CyBank

---

#  Choix techniques

## Utilisation de PHP

Le projet a été développé en PHP car il permet de créer facilement des applications web dynamiques côté serveur.

PHP a été utilisé pour :

- gérer les sessions utilisateurs ;
- traiter les formulaires ;
- gérer les commandes ;
- contrôler les accès selon les rôles ;
- communiquer avec la plateforme de paiement CyBank.

---

## Utilisation de fichiers JSON

Les données sont stockées dans des fichiers JSON plutôt que dans une base de données.

Ce choix a été fait pour :

- simplifier le développement ;
- faciliter la lecture des données ;
- éviter l'installation et la configuration d'un serveur SQL ;
- permettre une sauvegarde rapide des informations.

Les fichiers JSON utilisés sont :

- utilisateurs.json
- livreurs.json
- plats.json
- menus.json
- commandes.json

---

## Gestion des rôles

Le système repose sur plusieurs rôles :

### Client

Peut :

- consulter les produits ;
- passer commande ;
- modifier certaines commandes ;
- suivre ses commandes.

### Livreur

Peut :

- consulter les livraisons attribuées ;
- mettre à jour l'état des commandes.

### Restaurateur

Peut :

- gérer les commandes ;
- préparer les commandes ;
- attribuer les livreurs.

### Administrateur

Dispose des droits complets :

- gestion des utilisateurs ;
- blocage et déblocage des comptes ;
- supervision générale du site.

---

## Sécurité

Plusieurs mécanismes ont été mis en place :

### Protection CSRF

Chaque formulaire contient un jeton CSRF permettant de vérifier l'origine de la requête.

### Contrôle des accès

Certaines pages ne sont accessibles qu'aux utilisateurs authentifiés.

Des vérifications sont effectuées avant chaque action sensible.

### Validation des données

Les données sont contrôlées :

- côté client avec JavaScript ;
- côté serveur avec PHP.

### Protection XSS

Les données affichées sont sécurisées grâce à :

```php
htmlspecialchars(...)
```

afin d'éviter l'injection de code HTML ou JavaScript.

---

## Gestion du thème

Le site dispose :

- d'un thème clair ;
- d'un thème sombre.

Le choix de l'utilisateur est enregistré dans un cookie afin d'être conservé lors des prochaines visites.

---

## Adaptation

Le site est compatible :

- ordinateur ;
- tablette ;
- smartphone.


## Architecture générale

Le projet suit une architecture simple :

- Front-end :
  - HTML
  - CSS
  - JavaScript

- Back-end :
  - PHP

- Stockage :
  - JSON

Cette organisation facilite la maintenance et la compréhension du code.

#  Installation
1. Cloner le projet

```bash
git clone https://github.com/votre-compte/copa-cabanane.git
```

2. Placer le projet dans votre serveur web :

- XAMPP
- WAMP
- MAMP


3. Accéder au projet :
```text
   php -S localhost:1234
```
```text
http://localhost:1234/index.php
```

---

#  Auteur

Projet réalisé dans le cadre du cursus PréIng2 SUPMECA.

Membres: 

-VERDINI Emily
-GOMES Mathias

Copa Cabanane © 2026 🍌
