<?php
session_start();
include('./PageParts/variables.php');
include('./PageParts/databaseFunctions.php');

$posttype = "Message";
$titreTopic = "Gagner des points";
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
    <div class="main_container">

        <div id="Ajout" class="fenetre_interaction">

            <img id="Start_game" src="./images/Start_game.png" alt="Start a new Game">

            <h1>Nouveau <?php echo $posttype ?></h1>
            <br><p>________________________________________</p><br>

            <form id="saisir_titre" action="#" method="post">


                <div id="entrer_titre" class="entrees">

                    <?php if($posttype == "Topic"){?>
                        <label>Saisissez un titre pour votre Topic :
                            <br><input type="text" name="choix_titre" placeholder="Titre">
                        </label>

                    <?php }else{?>

                        <p>Topic : <?php echo $titreTopic ?></p>
                    <?php }?>

                </div>

                <br><br>

                <div id="saisir_message" class="entrees">
                    <label>Saisissez votre <?php if($posttype == "Topic"){ echo "premier "; }?>message :
                        <br>
                        <textarea id="message" name="choix_message" placeholder="Message"></textarea>
                    </label>
                </div>

                <br><input class="Boutons" type="button" value="<?php if($posttype == "Topic"){echo "Créer Topic";}

                else{echo "Envoyer Message";}?>">

            </form>
        </div>
    </div>
</body>
</html>
