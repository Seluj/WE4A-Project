<h1>Topic au sujet de <?php $nomJeu ?> </h1>
<h2>Titre du Topic : <?php $nomTopic ?> </h2>

<img class="image_jeu" src="<?php echo $imagejeu ?>" alt="avatar">

<div id="<?php if ($type="Jeu") {echo "description_jeu";} else {echo "description_topic";} ?>">
    <h2>Description :</h2>
    <p><?php echo $descriptionJeu ?></p>
</div>

<h2 id="telecharger_regle" class="linkBox"><a href="<?php echo $regles ?>" download="<?php echo 'regles_' . $nomJeu ?>.pdf">Télécharger les règles de <?php echo $nomJeu ?></a></h2>
<?php if ($connecte) {?>
    <div id="BoutonCreerMessage" class="linkBox">
        <a class="police" href="./newMessage.php?topic=<?php echo $idTopic ?>">Créer Message</a>
    </div>
<?php } ?>

<div class="deroulant">
    <h3>Messages associés</h3>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($messages)) { ?>
            <li><?php echo $row["date_ajout"]?><br><?php echo $row["contenu"]?></li>
            <?php } ?>
    </ul>
</div>