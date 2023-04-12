<?php
include("./PageParts/variables.php");
include("./functions/databaseFunctions.php");
include("./functions/accessFunctions.php");
include("./functions/accountFunctions.php");
include("./functions/gamesFunctions.php");

session_start();

connectDatabase();
checkAccount();

$idJeu="";
$nom_jeu = "";
$description_jeu = "";
$image_jeu = "";
$regles_jeu="";
$type_jeu = "";

if(isset($_GET["jeu"])){
    $idJeu = $_GET["jeu"];
    $jeu=getJeux($idJeu,"one");
    $nom_jeu = $jeu["Nom"];
    $description_jeu = $jeu["Description"];;
    $image_jeu = $jeu["image"];
    $regles_jeu=$jeu["regles"];
    $type_jeu = $jeu["type"];
}else{
    $idJeu=-1;
}


checkNewGame();

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

<div class="main_container">

    <?php include('./PageParts/profile.php')?>

    <div class="container central">
        <?php if($idJeu == -1){ ?>
            <img class="image_commentaire" src="<?php echo $littleImagePathLink."New_Game.png" ?>" alt="New Game !">
        <?php } else {?>
            <img class="image_commentaire" src="<?php echo $littleImagePathLink."Game_Changer.png" ?>" alt="Game Changer!">
        <?php } ?>
        <h1 class="titre_interaction"><?php if($idJeu==-1){echo "Ajouter un jeu";}else{echo "Modifier le jeu";} ?></h1>


        <form class="formulaire" method="post" action="#" enctype="multipart/form-data">

            <div class="entrees">
                <label for="nom">Nom</label>
                <input id="nom" class="saisie" name="nom" type="text" required="required" pattern="[a-zA-Z-'--- -é-è-à-ç]{1,20}" value="<?php echo $nom_jeu ?>"/>
            </div>
            <br><br>

            <div id="saisir_description" class="entrees">
                <label for="description">Saisissez la description du jeu</label>
                <textarea id="description" name="choix_description" placeholder="Description" ><?php echo $description_jeu ?></textarea>

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
                <input type="radio" id="type_jeu_societe" name="type_jeu" value="societe" <?php if($type_jeu == 0){echo "checked";}?>><br>

                <label for="type_jeu_video">Jeu Vidéo</label>
                <input type="radio" id="type_jeu_video" name="type_jeu" value="video" <?php if($type_jeu == 1){echo "checked";}?>>
            </div>
            <br><br>
            <?php if($idJeu==-1){ ?>
                <input class="Boutons" type="submit" name="creer_jeu" value="Créer Jeu" />
            <?php } else {?>
                <input class="Boutons" type="submit" name="modifier_jeu" value="Modifier Jeu" />
            <?php } ?>
        </form>

        <div id="Revenir_accueil" class="linkBox">
            <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
        </div>
    </div>

     <?php include('./PageParts/games.php')?>

</div>
</body>
</html>