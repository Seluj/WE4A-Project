<?php
session_start();
include('./PageParts/variables.php');
include('./PageParts/databaseFunctions.php');

if (!isset($_SESSION['id'])) {
    header("Location: ./index.php");
}

$posttype   = "";
$titreTopic = "";
$jeuID     = "";
$topicID    = "";
if(isset($_GET['topic'])){
    $topicID = $_GET['topic'];
    ConnectDatabase();
    $query = "SELECT `topics`.*
        FROM `topics`
        WHERE `topics`.`id_post` = '$topicID'";

    global $conn;
    $result = $conn->query($query);

    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_assoc($result);
        $titreTopic = $row['titre'];
        $posttype = "Message";
    } else {
        $posttype = "Topic";
    }
} else {
    $posttype = "Topic";
}
checkEntry();
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

    <?php include('./PageParts/header.php') ?>

    <!-- Reste de la page -->
    <div class="main_container">
        <?php include('./PageParts/profile.php')?>
        <div class="container central">
            <img class="image_commentaire" src="./images/Welcome_in_the_chat.png" alt="Start a new Game">

            <h1 class="titre_interaction">Nouveau <?php echo $posttype ?></h1>

            <form class="formulaire" action="#" method="post">


                <div id="entrer_titre" class="entrees">

                    <?php if($posttype == "Topic"){?>
                        <label for="choix_titre">Saisissez un titre pour votre Topic :</label>
                        <br><input type="text" name="choix_titre" placeholder="Titre"/>


                    <?php }else{?>

                        <p>Topic : <?php echo $titreTopic ?></p>
                    <?php }?>

                </div>

                <br><br>

                <div id="saisir_message" class="entrees">
                    <label for="choix_message">Saisissez votre <?php if($posttype == "Topic"){ echo "premier "; }?>message :</label>
                    <br>
                    <textarea id="message" name="choix_message" placeholder="Message"></textarea>

                </div>

                <br><input class="Boutons" name="createNewMessage" type="submit" value="<?php if($posttype == "Topic"){echo "Créer Topic";}

                else{echo "Envoyer Message";}?>">

            </form>
            <div id="Revenir_accueil" class="linkBox">
                <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
            </div>
        </div>
        <?php include('./PageParts/games.php')?>
    </div>
</body>
</html>