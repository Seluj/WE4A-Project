
<?php
$nomsite = "Dice & Pixels";

include('./PageParts/databaseFunctions.php')
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

<div id="utilisateurs" class="main">
	<h1>Joueurs</h1>
	<ul>
        <?php boucle("Utilisateur", 20) ?>
	</ul>
</div>

<div id="messages" class="main">
	<h1>Liste des messages de la discussion</h1>
	<ul>
        <?php boucle("Message", 20) ?>
	</ul>
</div>

<div id="jeux" class="main">
    
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

</body>
</html>