<?php
include("./PageParts/databaseFunctions.php");
include("./PageParts/variables.php");

session_start();

ConnectDatabase();
checkAccount();
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

<div class="main_container main_interaction_container">

    <div class="container interaction_container">

        <img class="image_commentaire" src="./images/NewPlayer.png" alt="New Player !">

        <h1 class="titre_interaction">Créer un compte</h1>

        <br><p>________________________________________</p><br>

        <form class="formulaire" method="post" action="#" enctype="multipart/form-data">

            <div class="entrees">
                <label for="nom">Nom</label>
                <input id="nom" class="saisie" name="nom" type="text" required="required" pattern="[a-zA-Z-'--- -é-è-à-ç]{1,20}" value="<?php echo $nom ?>"/>
            </div>
            <br><br>
            <div class="entrees">
                <label for="prenom" class="placeholder">Prénom</label>
                <input id="prenom" class="saisie" name="prenom" type="text" required="required" pattern="[a-zA-Z-'---é-è-à-ç]{1,20}" value="<?php echo $prenom ?>" />
                <div class="cut cut-prenom"></div>
            </div>

            <br><br>
            <div class="entrees">
                <label for="email">Email</label>
                <input id="email" class="saisie" name="email" type="email" required="required" value="<?php echo $email ?>"/>
            </div>
            <br><br>
            <?php if(!$connecte){?>
                <div class="entrees">
                    <label for="mdp">Mot de passe</label>
                    <input id="mdp" class="saisie" name="mdp" type="password" required="required" pattern="[a-zA-Z0-9-'--]{8,100}"/>
                </div>
            <?php } else {?>
                <button class="Boutons" type="button" id="modifierMDP"  onClick="myFunction()">Modifier mot de passe</button>
            <?php } ?>
            <br><br>
            <div class="entrees">
                <label for="pseudo">Pseudo</label>
                <input id="pseudo" class="saisie" name="pseudo" type="text" required="required" pattern="[a-zA-Z0-9-'--]{1,20}" value="<?php echo $pseudo ?>"/>
            </div>
            <br><br>
            <div class="entrees">
                <label for="avatar">Avatar</label>
                <input id="avatar" name="avatar" type="file">
            </div>
            <br><br>
            <div class="entrees">
                <label for="affichage_nom">Afficher mon nom</label>
                <input id="affichage_nom" class="saisie" name="affichage_nom" type="checkbox" <?php if($affichage_nom){echo "checked";} ?>>
            </div>
            <br><br>
            <?php if(!$connecte){ ?>
                <input class="Boutons" type="submit" name="inscrire" value="S'inscrire" />
                <button class="Boutons" type="button" id="button2"  onClick="myFunction()">Se connecter</button>
            <?php } else {?>
                <input class="Boutons" type="submit" name="modifier_profil" value="Modifier Profil" />
            <?php } ?>
        </form>
    </div>

    <div id="Revenir_accueil" class="linkBox">
        <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
    </div>
</div>
</body>
</html>