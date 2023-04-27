
<h1>Topic à propos de <?php echo $nomJeu ?> </h1>

<a href="./index.php?site=<?php echo $siteCourant ?>&jeu=<?php echo $idJeu ?>">
    <img class="image_jeu" src="<?php echo $imageJeu ?>" alt="avatar" title="<?php echo $nomJeu ?>">
</a>

<h2 id="titre_topic" >Sujet : <?php echo $nomTopic ?> </h2><br>

<?php include("./PageParts/listTopicsMessages.php") ?>
