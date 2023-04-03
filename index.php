<?php
session_start();
include('./PageParts/variables.php');
include('./PageParts/databaseFunctions.php');

$affichage_nom = 0;
$pseudo = "Goodman";
$prenom = "Jean";
$nom = "Menton";
$description = "blabla";
$avatar = "images/Avatar.jpg";

if($affichage_nom == 0){
    $utilisateur = $pseudo;
}else{
    $utilisateur = $prenom." ".$nom;
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

    <?php include('./PageParts/header.php') ?>

    <!-- Reste de la page -->
    <div class="main_container">

        <div id="utilisateurs" class="container">

            <div id="profil">
                <h1><a href="">Profil</a></h1>
                <div>
                    <img class="avatar" src=<?php echo $avatar ?> alt="avatar">
                    <h2><?php echo $utilisateur ?></h2>
                </div>
                <div>
                    <?php echo $description ?>
                </div>
            </div>

            <ul>
                <?php boucle("Utilisateur", 20) ?>
            </ul>
        </div>

        <div id="messages" class="container">
            <h1>Liste des messages de la discussion</h1>
            <ul>
                <?php boucle("Message", 20) ?>
            </ul>
        </div>

        <div id="jeux" class="container">

            <div class="liste_jeux" id="jeux_visites">
                <h1>Liste des jeux visités</h1>
                <ul>
                    <?php boucle("Jeu", 20) ?>
                </ul>
            </div>

            <div class="liste_jeux" id="jeux_proposes">
                <h1>Liste des jeux proposés</h1>
                <ul>
                    <?php boucle("Jeu", 20) ?>
                </ul>
            </div>
        </div>

    </div>
</body>
</html>