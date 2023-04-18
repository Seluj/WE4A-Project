<h1>Jeu : <?php echo $nomJeu;?></h1>

<img class="image_jeu" src="<?php echo $imageJeu ?>" alt="avatar">

<?php if ($administrateur) {?>
    <div id="BoutonModifierJeu" class="linkBox">
        <a class="police" href="./newGame.php">Modifier Jeu</a>
    </div>
<?php } ?>

<div id="<?php if ($type="Jeu") {echo "description_jeu";} else {echo "description_topic";} ?>">
    <h2>Description :</h2>
    <p><?php echo $descriptionJeu ?></p>
</div>

<?php if($regles != $rulesGamesPathLink."-1"){ ?>
    <h2 id="telecharger_regle" class="linkBox"><a href="<?php echo $regles ?>" download="<?php echo 'regles_' . $nomJeu ?>.pdf">Télécharger les règles de <?php echo $nomJeu ?></a></h2>
<?php } ?>
<?php if ($connecte) {?>
    <div id="BoutonCreerTopic" class="linkBox">
        <a class="police" href="./newMessage.php?jeu=<?php echo $idJeu ?>">Créer Topic</a>
    </div>
<?php } ?>

<div class="deroulant">
    <?php if($topics != false){?>
        <h3><?php echo "Topics associés à ".$nomJeu;?></h3>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($topics)) { ?>
                <li><a href="./index.php?site=<?php echo $siteCourant ?>&topic=<?php echo $row['id'] ?>">
                    <?php echo $row["titre"] ?><br>
                    <?php echo getMessages($row["id"],"first")["contenu"] ?>
                </a></li>
            <?php } ?>
        </ul>
    <?php } else {?>
        <h3><?php echo "Aucun Topic associé à ".$nomJeu;?></h3>
    <?php } ?>
</div>