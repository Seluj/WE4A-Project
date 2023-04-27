<?php
session_start();
include('./PageParts/variables.php');
include('./functions/databaseFunctions.php');
include('./functions/accessFunctions.php');
include("./functions/postFunctions.php");

connectDatabase();

if (!isset($_SESSION['id'])) {
    header("Location: ./index.php");
}

if (!checkParameter("topic") && !checkParameter("jeu")) {
    header("Location: ./index.php");
}

$postType = "";
$titreTopic = "";
$jeuID = "";
$topicID = "";

if (isset($_GET['topic'])) {
    $topicID = $_GET['topic'];
    $row = getTopics($topicID, "one");

    if ($row) {
        $titreTopic = $row['titre'];
        $postType = "Message";
    } else {
        $postType = "Topic";
    }
} else {
    $postType = "Topic";
}

$site = checkSite('newMessage.php');
$siteCourant = $site;

checkEntry();
?>


<!DOCTYPE html>

<html lang="fr">


<head>
    <?php include('./PageParts/head.php') ?>
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php') ?>

    <!-- Reste de la page -->
    <div class="main_container">
        <?php include('./PageParts/users.php') ?>
        <div class="container central deroulant">
            <img class="image_commentaire" src="./images/Welcome_in_the_chat.png" alt="Start a new Game">

            <h1 class="titre_interaction">Nouveau <?php echo $postType ?></h1>

            <form class="container_list" action="#" method="post">


                <div id="entrer_titre" class="entrees">

                    <?php if ($postType == "Topic") {?>
                        <label for="choix_titre">Saisissez un titre pour votre Topic :</label>
                        <br><input id="saisie_topic" type="text" name="choix_titre" placeholder="Titre"/>


                    <?php } else {?>

                        <p>Topic : <?php echo $titreTopic ?></p>
                    <?php } ?>

                </div>

                <br><br>

                <div id="saisir_message" class="entrees">
                    <label for="choix_message">Saisissez votre <?php if ($postType == "Topic") { echo "premier "; }?>message :</label>
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
