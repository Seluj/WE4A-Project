<!-- PageParts/CentralDiv/games.php -->
<!-- Fichier contenant l'affichage d'un jeu lorsqu'un utilisateur a cliqué sur un jeu -->


<h1>Jeu : <?php echo $nomJeu; ?></h1>

<img class="image_jeu" src="<?php echo $imageJeu; ?>" alt="jeu">

<div id="description_jeu">
    <h2>Description :</h2>
    <p><?php echo $descriptionJeu; ?></p>
</div>

<?php if ($regles != $rulesGamesPathLink . "-1") { ?>
    <h2 id="telecharger_regle" class="linkBox"><a href="<?php echo $regles; ?>" download="<?php echo 'regles_' . $nomJeu; ?>.pdf">>> Télécharger les règles de <?php echo $nomJeu; ?></a></h2>
<?php } ?>


<?php include("./PageParts/listTopicsMessages.php"); ?>
<br>
<div class="Boutons Revenir_accueil">
    <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
</div>