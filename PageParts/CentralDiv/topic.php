<!-- PageParts/CentralDiv/topic.php -->
<!-- Fichier contenant l'affichage d'un topic lorsqu'un utilisateur a cliqué sur un topic -->

<h1>Topic à propos de <?php echo $nomJeu ?> </h1>

<a href="./index.php?site=<?php echo $siteCourant; ?>&jeu=<?php echo $idJeu; ?>">
    <img class="image_jeu" src="<?php echo $imageJeu; ?>" alt="avatar" title="<?php echo $nomJeu; ?>">
</a>

<h2 id="titre_topic" >Sujet : <?php echo $nomTopic; ?> </h2><br>

<!-- On affiche ensuite les messages du topic -->
<?php include("./PageParts/listTopicsMessages.php"); ?>

<br>

<div class="Boutons Revenir_accueil">
    <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
</div>