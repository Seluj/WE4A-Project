<!-- PageParts/proposedGames.php -->
<!-- Fichier contenant l'affichage des jeux proposés à l'utilisateur -->


<div id="jeux" class="container">

    <!-- Si l'utilisateur est administrateur, on affiche le bouton pour pouvoir ajouter un jeu -->
    <?php if ($administrateur) {?>
    <div id="BoutonAjouterJeu" class="linkBox">
        <a class="police" href="./newGame.php">Ajouter Jeu</a>
    </div>
    <?php } ?>


    <!-- Liste des jeux proposés en fonction du type de jeu courant (vidéo / société) -->
    <div class="liste_jeux" id="jeux_proposes">
        <h1><?php echo $nomSectionJeux; ?></h1>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($jeux)) { ?>
                <li>
                    <img class="avatar" src="<?php echo $imagesGamesPathLink . $row['image']; ?>" alt="image jeu">
                    <a href="./index.php?site=<?php echo $row["type"]; ?>&jeu=<?php echo $row['id']; ?>">
                    <?php echo $row["Nom"]; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>