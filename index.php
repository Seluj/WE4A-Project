
<?php
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
<title>Nom du site</title>
<link rel="stylesheet" href="./Styles/style.css"> 
</head>

<body>

<div id="bandeau">

	<p>Nom du site</p>

</div>

<div id="utilisateurs" class="main">
	<h1>Liste de quelques utilisateurs</h1>
	<ul>
        <?php boucle("Utilisateur", 40) ?>
	</ul>
</div>

<div id="messages" class="main">
	<h1>Liste des messages de la discussion</h1>
	<ul>
        <?php boucle("Message", 40) ?>
	</ul>
</div>

<div id="jeux" class="main">
    
	<div class="liste_jeux" id="jeux_visites">
		<h1>Liste des jeux visités</h1>
		<ul>
            <?php boucle("Jeu", 40) ?>
		</ul>
	</div>

	<div class="liste_jeux" id="jeux_proposes">
		<h1>Liste des jeux proposés</h1>
		<ul>
            <?php boucle("Jeu", 40) ?>
		</ul>
	</div>
</div>

</body>
</html>