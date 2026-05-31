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

#  Installation

1. Cloner le projet

```bash
git clone https://github.com/votre-compte/copa-cabanane.git
```

2. Placer le projet dans votre serveur web :

- XAMPP
- WAMP
- MAMP

3. Démarrer Apache

4. Accéder au projet :

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
