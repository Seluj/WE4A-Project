<?php
session_start();
include('./PageParts/variables.php');
include('./functions/databaseFunctions.php');
include('./functions/accessFunctions.php');

ConnectDatabase();

$imagejeu = "images/carcassonne.jpg";
$nomJeu = "Carcassonne";
$descriptionJeu ="Retrouvez l’ambiance médiévale en partant à la conquête des terres et villes du sud de la France avec le jeu Carcassonne. Arpentez chemins et champs pour asseoir votre puissance, bloquez vos adversaires et triomphez par votre stratégie sur le tableau des scores.

Grâce à ses parties courtes, son mécanisme mêlant tactique et opportunisme, ce petit jeu a tout pour séduire et permettre de grands moments de jeu en famille.

Primé en Allemagne - « Spiel des Jahres 2001 » (Jeu de société de l’année) - Carcassonne est un jeu d’une très grande simplicité, accessible à tous et original.

Votre but : Obtenir le plus de points lors du décompte final.

A la manière des célèbres Dominos, le plateau de jeu se construit peu à peu au gré de la pose de « tuiles paysage » où l’on retrouve de morceaux de routes, champs et forteresses.

En plaçant judicieusement vos partisans sur le paysage constitué, vous pourrez acquérir des points grâce à la longueur des routes, la grandeur des villes ou des champs. Les points sont en effet décomptés dès qu’un élément (route, ville etc.) est achevé par la pose d’une tuile.

Le jeu s’achève lorsque toutes les tuiles ont été posées. Le paysage est constitué et le vainqueur est le joueur le plus avancé sur le tableau des points.

Carcassonne bénéficie de nombreuses extensions apportant de nouvelles règles et possibilités tactiques.";

$regles = "data/games/rules/regles_carcassonne.pdf";


if (!isset($_GET['site'])) {
    header("Location: ./index.php?site=0");
}

$site = $_GET['site'];
if ($site != 0 && $site != 1) {
    header("Location: ./index.php?site=0");
}

if (isset($_GET['jeu'])) {
    $idJeu = $_GET['jeu'];
    $jeu = getJeux($idJeu, "one");

    if (!$jeu) {
        ?>
        <script>
            alert("Le jeu n'existe pas");
        </script>

        <?php
        header("Location: ./index.php");
    } else {
        $nomJeu = $jeu['nom'];
        $descriptionJeu = $jeu['description'];
        $imagejeu = $imagesGamesPathLink.$jeu['image'];
        $regles = $rulesGamesPathLink.$jeu['regles'];
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
        header("Location: ./index.php");
    } else {
        $nomTopic = $topic['titre'];
        $idJeu = $topic['jeu'];
        $jeu = getJeux($idJeu, "one");
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
        header("Location: ./index.php");
    } else {
        $idTopic = $message['topic'];
        $topic = getTopics($idTopic, "one");
        $idJeu = $topic['jeu'];
        $jeu = getJeux($idJeu, "one");
    }
} else if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // TODO : Recherche
} else {
    $jeux = getJeux(0, "all");
}

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


        <div class="container central">

            <h1>Jeu : <?php echo $nomJeu ?></h1>
            <img id="image_jeu" src="<?php echo $imagejeu ?>" alt="avatar">
            <?php if($administrateur){?>
                <div id="BoutonModifierJeu" class="linkBox">
                    <a class="police" href="./newGame.php">Modifier Jeu</a>
                </div>
            <?php } ?>
            <div id="description_jeu">
                <h2>Description :</h2>
                <p><?php echo $descriptionJeu ?></p>
            </div>
            <h2 id="telecharger_regle" class="linkBox"><a href="<?php echo $regles ?>" download="Regles_carcassonne.pdf">Télécharger les règles de <?php echo $nomJeu ?></a></h2>
            <?php if($connecte){?>
            <div id="BoutonCreerTopic" class="linkBox">
                <a class="police" href="./newMessage.php">Créer Topic</a>
            </div>
            <?php } ?>
            <h3>Topics associés</h3>
            <ul>
                <?php boucle("Message", 20) ?>
            </ul>
        </div>

        <?php include('./PageParts/games.php')?>

    </div>
</body>
</html>