<?php
session_start();
include('./PageParts/variables.php');
include('./functions/databaseFunctions.php');
include('./functions/accessFunctions.php');

connectDatabase();

$type = "";

$imageJeu = "";
$nomJeu = "";
$descriptionJeu ="";
$regles = "";
$idJeu = -1;
$idTopic = -1;


$site = checkSite('index.php');
$siteCourant = $site;

if (isset($_GET['jeu'])) {
    $idJeu = intval($_GET['jeu']);
    $jeu = getJeux($siteCourant, $idJeu);

    if (!$jeu) {
        ?>
        <script>
            alert("Le jeu n'existe pas");
        </script>

        <?php
        header("Location: ./index.php?site=" . $site);
    } else {
        $nomJeu = $jeu['Nom'];
        $descriptionJeu = $jeu['Description'];
        $imageJeu = $imagesGamesPathLink . $jeu['image'];
        $regles = $rulesGamesPathLink . $jeu['regles'];
        $type = "Jeu";

        $topics = getTopics($idJeu, "all");
    }
} else if (isset($_GET['topic'])) {
    $idTopic = intval($_GET['topic']);
    $topic = getTopics($idTopic, "one");

    if (!$topic) {
        ?>
        <script>
            alert("Le topic n'existe pas");
        </script>

        <?php
        header("Location: ./index.php?site=" . $site);
    } else {
        $nomTopic = $topic['titre'];
        $idJeu = $topic['jeux_id'];
        $jeu = getJeux($siteCourant, $idJeu);
        $type = "Topic";
        $firstMessage = getMessages($idTopic,"fist");
        $messages = getMessages($idTopic,"all");
        $nomJeu = $jeu['Nom'];
        $imageJeu = $imagesGamesPathLink . $jeu['image'];
        $regles = $rulesGamesPathLink . $jeu['regles'];
    }
} else {
    $type = "default";
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    switch ($type) {
        case "Jeu":
            $searchJeux = searchInGame($idJeu, $search);
            break;
        case "Topic":
            $searchTopics = searchInTopic($idTopic, $search);
            break;
        case "default":
            $searchDefault = searchInAll($search);
            break;
        /*
        case "message":

                break;
        */
        default:
            break;
    }
}
?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <?php include('./PageParts/head.php') ?>
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php')?>

    <!-- Reste de la page -->
    <div class="main_container">

        <?php include('./PageParts/users.php') ?>

        <div class="container central">


            <?php
            //echo 'je suis de type : ' . $type;
            switch ($type) {
                case "Jeu":
                    include('./PageParts/CentralDiv/games.php');
                    break;
                case "Topic":
                    include('./PageParts/CentralDiv/topic.php');
                    break;
                case "default":
                    include('./PageParts/CentralDiv/default.php');
                    break;
                default:
                    //echo "J'ai un problème : tu es vraiment dans le default";
                    break;
            }
            ?>

        </div>
        <?php include('./PageParts/proposedGames.php') ?>

    </div>
</body>
</html>