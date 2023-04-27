<?php echo "coucou";//$nbrResult = mysqli_num_rows($searchResults);
?>

<h1>Résultat de la recherche : <?php $search ?> </h1>
<h2>Nombres de résultats : <?php echo $nbrResult ?> </h2>
<div>
    <?php if($typeSearch == "Topic"){ ?>
        <h2>Topics : </h2>
    <?php } ?>

    <?php while ($row = mysqli_fetch_assoc($searchResults)) { ?>
    <li id="one_topic" class="entrees"><a>
            <p class="titre_topic"><?php echo $row["id"] ?></p>
        </a></li><br>
    <?php } ?>
</div>




<h2 id="telecharger_regle" class="linkBox"><a href="<?php echo $regles ?>" download="<?php echo 'regles_' . $nomJeu ?>.pdf">Télécharger les règles de <?php echo $nomJeu ?></a></h2>
<?php if ($connecte) {?>
    <div id="BoutonCreerTopicMessageMessage" class="linkBox">
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