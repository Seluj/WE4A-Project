<!-- PageParts/variables.php -->
<!-- Fichier contenant les variables utilisées dans les autres fichiers -->


<?php

// Variable à modifier pour changer le lien vers la racine du site
// Lien vers la racine du site pour la récupération des données (images, règles, etc.). Concaténé avec les autres variables pour obtenir le lien complet
$headLink = "http://chris.ferlin.fr:6969/Projet/";


$nomSite = "Dice & Pixels";                             // Nom du site
$nomSectionJeux = "Jeux proposés";                      // Nom de la section des jeux proposés
$imagePathLink = $headLink . "data/users/images";       // Lien vers le dossier contenant les images des utilisateurs
$imagePath = "./data/users/images/";                    // Chemin vers le dossier contenant les images des utilisateurs pour la sauvegarde des données (images, règles, etc.)
$littleImagePathLink = $headLink . "images/";           // Lien vers le dossier contenant les images du site
$rulesGamesPathLink = $headLink . "data/games/rules";   // Lien vers le dossier contenant les règles des jeux
$rulesGamesPath = "./data/games/rules/";                // Chemin vers le dossier contenant les règles des jeux
$imagesGamesPathLink = $headLink . "data/games/images"; // Lien vers le dossier contenant les images des jeux
$imagesGamesPath = "./data/games/images/";              // Chemin vers le dossier contenant les images des jeux
$pageNewAccount = false;                                // Booléen indiquant si l'utilisateur est sur la page de création de compte, par défaut à false
?>

