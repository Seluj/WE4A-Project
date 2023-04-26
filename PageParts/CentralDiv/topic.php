<h1>Topic à propos de <?php echo $nomJeu ?> </h1>

<a href="./index.php?site=<?php echo $siteCourant ?>&jeu=<?php echo $idJeu ?>">
    <img class="image_jeu" src="<?php echo $imageJeu ?>" alt="avatar" title="<?php echo $nomJeu ?>">
</a>

<h2 id="titre_topic" >Sujet : <?php echo $nomTopic ?> </h2>

<?php if ($connecte) {?>
    <div id="BoutonCreerMessage" class="linkBox">
        <a class="police" href="./newMessage.php?topic=<?php echo $idTopic ?>">Créer Message</a>
    </div>
<?php } ?>

<?php include("./PageParts/listTopicsMessages.php") ?>
