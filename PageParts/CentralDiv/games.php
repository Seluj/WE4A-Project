<h1>Jeu : <?php echo $nomJeu;?></h1>

<img class="image_jeu" src="<?php echo $imageJeu ?>" alt="avatar">

<?php if ($administrateur) {?>
    <div id="BoutonModifierJeu" class="linkBox">
        <a class="police" href="./newGame.php?site=<?php echo $siteCourant ?>&jeu=<?php echo $idJeu; ?>">Modifier Jeu</a>
    </div>
<?php } ?>

<div id="<?php if ($type="Jeu") {echo "description_jeu";} else {echo "description_topic";} ?>">
    <h2>Description :</h2>
    <p><?php echo $descriptionJeu ?></p>
</div>

<?php if($regles != $rulesGamesPathLink."-1"){ ?>
    <h2 id="telecharger_regle" class="linkBox"><a href="<?php echo $regles ?>" download="<?php echo 'regles_' . $nomJeu ?>.pdf">>> Télécharger les règles de <?php echo $nomJeu ?></a></h2>
<?php } ?>


<?php include("./PageParts/listTopicsMessages.php") ?>

<div class="Boutons Revenir_accueil">
    <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
</div>