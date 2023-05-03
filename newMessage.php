<!-- newMessage.php -->
<!-- Fichier permettant à l'utilisateur de saisir un nouveau topic ou un nouveau message -->

<?php

session_start(); // Lancement de la session

// Inclusion des pages contenant les fonctions et variables utiles
include('./PageParts/variables.php');
include('./functions/databaseFunctions.php');
include('./functions/accessFunctions.php');
include("./functions/postFunctions.php");

// Connexion à la base de données
connectDatabase();

// Vérification de connexion : si l'utilisateur n'est pas connecté et tente d'aller sur cette page, on le redirige vers index.php
if (!isset($_SESSION['id'])) {
    header("Location: ./index.php");
}

/* Vérification : si aucune des deux variables topic ou jeu ne sont présentes dans l'url de la page,
elle ne peut pas fonctionner : on redirige donc vers l'accueil */
if (!checkParameter("topic") && !checkParameter("jeu")) {
    header("Location: ./index.php");
}

//Déclaration et initialisation des variables utiles dans la page
$postType = "";    // Type de post à créer (topic ou message)
$titreTopic = "";  // Titre du topic
$topicID = "";     // ID du topic
$jeuID = "";       // ID du jeu associé

// On récupère le site courant et on le sauvegarde puisque la valeur de $site va être modifiée dans le header
$site = checkSite('newMessage.php');
$siteCourant = $site;

// On identifie les parametres dans l'URL et on initialise les variables en fonction
if (isset($_GET['topic'])) { // Si on a un topic dans l'URL

    // On récupère l'identifiant du topic et on récupère les informations du topic
    $topicID = $_GET['topic'];
    $row = getTopics($topicID, "one");

    // On vérifie si le topic existe
    if ($row) { // Si le topic existe
        // On récupère le titre du topic
        $titreTopic = $row['titre'];
        // On attribue le type avec "Message" car on est dans un topic et on va créer un message
        $postType = "Message";
    } else { // Sinon
        // on attribue le type avec "Topic" car on est dans un jeu et on va créer un topic
        $postType = "Topic";
    }
} else { // Sinon
    // On attribue le type avec "Topic" car on est dans un jeu et on va créer un topic
    $postType = "Topic";
}

// On appelle la fonction de vérification de saisie
checkEntry();
?>


<!DOCTYPE html>

<html lang="fr">


<head>
    <!-- En-tête de la page -->
    <?php include('./PageParts/head.php') ?>
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php') ?>

    <!-- Reste de la page -->
    <div class="main_container">

        <!-- Colonne de gauche pour affichage des utilisateurs du site -->
        <?php include('./PageParts/users.php') ?>

        <!-- Colonne centrale pour affichage des messages -->
        <div class="container central deroulant">
            <img class="image_commentaire" src="./images/Welcome_in_the_chat.png" alt="Start a new Game">

            <h1 class="titre_interaction">Nouveau <?php echo $postType ?></h1>

            <form class="container_list" action="#" method="post">


                <div id="entrer_titre" class="entrees">

                    <?php if ($postType == "Topic") {?>
                        <label for="choix_titre">Saisissez un titre pour votre Topic :</label>
                        <br><input id="saisie_topic" type="text" name="choix_titre" placeholder="Titre"/>


                    <?php } else { ?>
                        <p>Topic : <?php echo $titreTopic; ?></p>
                    <?php } ?>

                </div>

                <br><br>
                <div id="saisir_message" class="entrees">
                    <label for="choix_message">Saisissez votre <?php if ($postType == "Topic") {echo "premier "; }?>message :</label>
                    <br>
                    <textarea class="zone_texte" id="message" name="choix_message" placeholder="Message"></textarea>

                </div>

                <br><input class="Boutons" name="createNewMessage" type="submit" value="<?php if ($postType == "Topic") {echo "Créer Topic";}

                else{echo "Envoyer Message";}?>">

            </form>
            <div id="Revenir_accueil" class="linkBox">
                <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
            </div>
        </div>
        <?php include('./PageParts/proposedGames.php') ?>
    </div>
</body>
</html>
