
<?php

$nomsite = "Dice & Pixels";

function boucle($string, $number)
{
   for($i = 1; $i <= $number; $i++) {
                 ?><li><?php echo $string." ".$i ?></li><?php
       }
}
?>


<!DOCTYPE html>

<html lang="fr">


<head>
<meta charset="UTF-8">
<title><?php echo $nomsite ?></title>
<link rel="stylesheet" href="./Styles/style.css"> 
</head>

<body>

<!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

<div id="bandeau">

<!-- Nom du site -->

	<p id="Nom_Site" class="police"><?php echo $nomsite ?></p>

    <!-- Barre de recherche -->


    <form action="#" method="post">
        <input type="text" name="recherche" placeholder="Rechercher">
        <input type="image" src="images/Loupe.png" alt="icone">
    </form>

    <!-- Bouton de connexion -->
    <div id="Connexion">
        <img src="images/Meeple.png" alt="icone">
        <a class="police" href="">Se Connecter</a>
    </div>


</div>







<div id="utilisateurs" class="main">
	<h1>Liste de quelques utilisateurs</h1>
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