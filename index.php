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
                    <img class="avatar" src="<?php echo $avatar ?>" alt="avatar">
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



        <div id="central" class="container">

            <h1>Jeu : <?php echo $nomJeu ?></h1>
            <img id="image_jeu" src="<?php echo $imagejeu ?>" alt="avatar">
            <div id="description_jeu">
                <h2>Description :</h2>
                <p><?php echo $descriptionJeu ?></p>
            </div>
            <a href="./images/regles_carcassonne.pdf" download="Regles_carcassonne.pdf">Télécharger les règles de <?php echo $nomJeu ?>:</a>
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