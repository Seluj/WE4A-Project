<h1><?php echo $type." : ".$nomJeu ?></h1>

<img id="image_jeu" src="<?php echo $imagejeu ?>" alt="avatar">

<?php if($administrateur){?>
    <div id="BoutonModifierJeu" class="linkBox">
        <a class="police" href="./newGame.php">Modifier Jeu</a>
    </div>
<?php }?>

<div id="<?php if($type="Jeu"){ echo "description_jeu";}else{echo "description_topic";}?>">
    <h2>Description :</h2>
    <p><?php echo $descriptionJeu ?></p>
</div>

<h2 id="telecharger_regle" class="linkBox"><a href="<?php echo $regles ?>" download="Regles_carcassonne.pdf">Télécharger les règles de <?php echo $nomJeu ?></a></h2>
<?php if($connecte){?>
    <div id="BoutonCreerTopic" class="linkBox">
        <a class="police" href="./newMessage.php">Créer Topic</a>
    </div>
<?php } ?>

<?php if($type="Jeu"){ ?>}
    <h3>Topics associés</h3>
<?php } ?>