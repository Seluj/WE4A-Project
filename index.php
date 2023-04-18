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


$site = checkSite('index.php');

if (isset($_GET['jeu'])) {
    $idJeu = $_GET['jeu'];
    $jeu = getJeux($idJeu, "one");

    if (!$jeu) {
        ?>
        <script>
            alert("Le jeu n'existe pas");
        </script>

        <?php
        header("Location: ./index.php?site=".$site);
    } else {
        $nomJeu = $jeu['Nom'];
        $descriptionJeu = $jeu['Description'];
        $imageJeu = $imagesGamesPathLink.$jeu['image'];
        $regles = $rulesGamesPathLink.$jeu['regles'];
        $type = "Jeu";
    }
} else if (isset($_GET['topic'])) {
    $idTopic = $_GET['topic'];
    $topic = getTopics($idTopic, "one");

    if (!$topic) {
        ?>
        <script>
            alert("Le topic n'existe pas");
        </script>

        <?php
        header("Location: ./index.php?site=".$site);
    } else {
        $nomTopic = $topic['titre'];
        $idJeu = $topic['jeu'];
        $jeu = getJeux($idJeu, "one");
        $type = "Topic";
    }
} else if (isset($_GET['message'])) {
    $idMessage = $_GET['message'];
    $message = getMessages($idMessage, "one");

    if (!$message) {
        ?>
        <script>
            alert("Le message n'existe pas");
        </script>

        <?php
        header("Location: ./index.php?site=".$site);
    } else {
        $idTopic = $message['topic'];
        $topic = getTopics($idTopic, "one");
        $idJeu = $topic['jeu'];
        $jeu = getJeux($idJeu, "one");
        $type = "message";
    }
} else if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // TODO : Recherche
} else {
    $jeux = getJeux(0, "all");
    $type = "default";
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    switch ($type) {
        case "Jeu":
            // TODO: Search in game
            break;
        case "Topic":
            // TODO: Search in topic
            break;
        case "default":
            // TODO: Search in all
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
<meta charset="UTF-8">
<title><?php echo $nomSite ?></title>
<link rel="stylesheet" href="./Styles/style.css">
<link rel="stylesheet" href="./Styles/header.css">
<link rel="stylesheet" href="./Styles/interaction.css">
<link rel="icon" href="images/icone.png">
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php')?>

    <!-- Reste de la page -->
    <div class="main_container">

        <?php include('./PageParts/profile.php')?>

        <?php
        /*
        switch ($type) {
            case "jeu":
                include('./PageParts/jeu.php');
                break;
            case "topic":
                include('./PageParts/topic.php');
                break;
            case "message":
                include('./PageParts/message.php');
                break;
            case "default":
                include('./PageParts/default.php');
                break;
            default:
                break;
        }
        */
        ?>


        <div class="container central">

            <?php if ($type == "Jeu") {
                include('./PageParts/game_presentation.php');
            } else {
                ?>
                <div class="deroulant">
                    <img id="image_titre" src="./images/fond_titre.jpg" alt="Bienvenue">
                    <?php if(!$connecte){ ?>
                        <p class="texte_accueil">Venez vous plongez avec nous dans le monde des jeux de société et des jeux vidéos ! Vous souhaitez découvrir de
                            nouveaux jeux, discuter stratégie et partager vos expériences de jeu avec d'autres passionnés dans un monde de
                            divertissement et de compétition ? Notre communauté dynamique est l'endroit idéal pour les joueurs occasionnels
                            et les compétiteurs chevronnés pour participer à des discussions animées, pour poser des questions et aider les
                            autres joueurs en répondant aux leurs.
                            Vous avez la possibilité de créer des topics à propos de jeux, d'y échanger avec les autres utilisateurs
                            au travers de messages, et de participer à des topics créés par d'autres. </p>
                    <?php }else{ ?>
                        <p class="texte_accueil"><?php echo "Bienvenue ".$utilisateur." !\n" ?>Découvre ici de nouveaux jeux ! Quelques-uns te sont proposés
                            dans la section "<?php echo $nomSectionJeux ?>", mais si tu en cherches un en particulier, utilise la barre de recherche dans le
                            bandeau supérieur.<br>Tu peux également y choisir le type de jeux qui te sont proposés !<br>Si tu as une question ou souhaites discuter
                            d'un aspects d'un jeu avec d'autres personnes, il te suffit d'aller sur la page du jeu et de créer un topic sur le sujet, et tout le monde
                            pourra venir y participer !</p>

                    <?php }
                    if ($administrateur) {?>
                        <div id="BoutonModifierJeu" class="linkBox">
                            <a class="police" href="./newGame.php">Ajouter Jeu</a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="deroulant">

                    <h3>Topics<?php if ($type == "Jeu") { echo " associés à ".$nomJeu;} ?></h3>
                <ul>
                    <?php boucle("Message", 20) ?>
                </ul>
            </div>
        </div>

        <?php include('./PageParts/games.php')?>

    </div>
</body>
</html>