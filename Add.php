<?php
session_start();
include('./PageParts/variables.php');
include('./PageParts/databaseFunctions.php');

$posttype = "Topic";
?>


<!DOCTYPE html>

<html lang="fr">


<head>
    <meta charset="UTF-8">
    <title><?php echo $nomsite ?></title>
    <link rel="stylesheet" href="./Styles/style.css">
    <link rel="icon" href="images/icone.png">
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php') ?>

    <!-- Reste de la page -->

    <div id="Ajout" class="fenetre_interaction">

        <h1>Nouveau <?php echo $posttype ?></h1>
        <br>
        <form id="saisir_titre" action="#" method="post">
            <?php if($posttype == "Topic"){?>
                <label>Saisissez un titre pour votre <?php echo $posttype ?> :
                    <input type="text" name="choix_titre" placeholder="Titre">
                </label>
            <?php }?>
            <br><br>
            <label>Saisissez votre message :
                <br><br>
                <textarea id="message" name="choix_message" placeholder="Message"></textarea>
            </label>
            <input type="button" value="Envoyer">
        </form>
    </div>

</body>
</html>
