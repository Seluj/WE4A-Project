<!-- newGame.php -->
<!-- Fichier contenant la page d'ajout d'un jeu -->


<?php
// On démarre la session
session_start();

// On inclut les fichiers nécessaires
include("./PageParts/variables.php");
include("./functions/databaseFunctions.php");
include("./functions/accessFunctions.php");
include("./functions/accountFunctions.php");
include("./functions/gamesFunctions.php");

// On se connecte à la base de données
connectDatabase();

// On initialise les variables
$idJeu = "";            // Variable contenant l'identifiant du jeu
$nomJeu = "";           // Variable contenant le nom du jeu
$descriptionJeu = "";   // Variable contenant la description du jeu
$imageJeu = "";         // Variable contenant le chemin vers l'image du jeu
$reglesJeu = "";        // Variable contenant le chemin vers les règles du jeu
$typeJeu = "";          // Variable contenant le type du jeu

// On récupère le site courant et on le sauvegarde puisque la valeur de $site va être modifiée dans le header
$site = checkSite('newGame.php');
$siteCourant = $site;

// On vérifie si on a un jeu dans l'URL pour le modifier
// ATTENTION la partie de modification n'est pas encore implémentée
if (isset($_GET["jeu"])) { // Si on a un jeu dans l'URL
    // On récupère l'identifiant du jeu et on récupère les informations du jeu
    $idJeu = $_GET["jeu"];
    $jeu = getJeux($siteCourant, $idJeu);
    $nomJeu = $jeu["Nom"];
    $descriptionJeu = $jeu["Description"];
    $imageJeu = $jeu["image"];
    $reglesJeu = $jeu["regles"];
    $type_jeu = $jeu["type"];
} else { // Sinon
    // On initialise les variables 0
    $idJeu = 0;
}

checkNewGame();

?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <!-- En-tête de la page -->
    <?php include('./PageParts/head.php'); ?>
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php'); ?>

    <!-- Reste de la page -->
    <div class="main_container">

        <!-- Colonne de gauche pour affichage des utilisateurs du site -->
        <?php include('./PageParts/users.php'); ?>

        <!-- Colonne centrale pour affichage du contenu -->
        <div class="container central deroulant" >

            <img class="image_commentaire" src="<?php echo $littleImagePathLink . "New_Game.png"; ?>" alt="New Game !">

            <h1 class="titre_interaction">Ajouter un jeu</h1>


            <form class="container_list" method="post" action="#" enctype="multipart/form-data">

                <div class="entrees">
                    <label for="nom">Nom</label>
                    <input id="nom" class="saisie" name="nom" type="text" required="required" pattern="[a-zA-Z-'--- -é-è-à-ç]{1,20}" value="<?php echo $nomJeu; ?>"/>
                </div>
                <br><br>

                <div id="saisir_description" class="entrees">
                    <label for="description">Saisissez la description du jeu</label>
                    <textarea class="zone_texte" id="description" name="choix_description" required="required" placeholder="Description" ><?php echo $descriptionJeu; ?></textarea>

                </div>
                <br><br>

                <div class="entrees">
                    <label for="saisie_regles_jeu">Règles du Jeu</label>
                    <input id="saisie_regles_jeu" class="input_center" name="saisie_regles_jeu" type="file">
                </div>
                <br><br>

                <div class="entrees">
                    <label for="saisie_image_jeu">Image du Jeu</label>
                    <input id="saisie_image_jeu" class="input_center" name="saisie_image_jeu" type="file">
                </div>
                <br><br>

                <div class="entrees">
                    <label for="type_jeu_societe">Jeu de société</label>
                    <input type="radio" id="type_jeu_societe" name="type_jeu" value="societe"><br>

                    <label for="type_jeu_video">Jeu Vidéo</label>
                    <input type="radio" id="type_jeu_video" name="type_jeu" value="video">
                </div>
                <br><br>

                <input class="Boutons" type="submit" name="creer_jeu" value="Créer Jeu" />

            </form><br><br>

            <div id="Revenir_accueil" class="linkBox">
                <a href="./index.php?site=<?php echo $siteCourant; ?>" class="backlink police"><< Revenir à l'accueil</a>
            </div>
        </div>

        <!-- Colonne de droite pour affichage des jeux proposés -->
         <?php include('./PageParts/proposedGames.php'); ?>

    </div>
</body>
</html>