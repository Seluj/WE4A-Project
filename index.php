<?php
session_start();
include('./PageParts/variables.php');
include('./functions/databaseFunctions.php');
include('./functions/accessFunctions.php');

connectDatabase();

$type = "";

$imagejeu = "";
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
        $imagejeu = $imagesGamesPathLink.$jeu['image'];
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
echo "jeu : ".$type;
?>

<!DOCTYPE html>

<html lang="fr">


<head>
<meta charset="UTF-8">
<title><?php echo $nomsite ?></title>
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
                include('./PageParts/presentation.php');
            } else {
                ?>
                <div class="deroulant">
                    <img id="image_titre" src="./images/fond_titre.jpg" alt="Bienvenue">

                    <p id="texte_presentation">Venez vous plongez avec nous dans le monde des jeux de société et des jeux vidéos ! Vous souhaitez découvrir de
                        nouveaux jeux, discuter stratégie et partager vos expériences de jeu avec d'autres passionnés dans un monde de
                        divertissement et de compétition ? Notre communauté dynamique est l'endroit idéal pour les joueurs occasionnels
                        et les compétiteurs chevronnés pour participer à des discussions animées, pour poser des questions et aider les
                        autres joueurs en répondant aux leurs.
                        Vous avez la possibilité de créer des topics à propos de jeux, d'y échanger avec les autres utilisateurs
                        au travers de messages, et de participer à des topics créés par d'autres. </p>
                    <?php if($administrateur){?>
                        <div id="BoutonModifierJeu" class="linkBox">
                            <a class="police" href="./newGame.php">Ajouter Jeu</a>
                        </div>
                    <?php }?>
                </div>
            <?php } ?>

            <div class="deroulant">

                    <h3>Topics<?php if($type="Jeu"){ echo " associés";} ?></h3>
                <ul>
                    <?php boucle("Message", 20) ?>
                </ul>
            </div>
        </div>

        <?php include('./PageParts/games.php')?>

    </div>
</body>
</html>