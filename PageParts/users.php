<!-- PageParts/users.php -->
<!-- Fichier contenant l'affichage des utilisateurs dans le volet de gauche de la page web -->


<div id="utilisateurs" class="container deroulant">

    <?php if ($connecte) { ?>
        <div id="profil">
            <h1><a href="">Profil</a></h1>
            <div>
                <img class="avatar" src="<?php echo $avatar; ?>" alt="avatar">
                <h2><?php echo $utilisateur; ?></h2>
            </div>
            <div id="presentation_profil">
                <?php echo $presentation; ?>
            </div>

            <?php // Si l'utilisateur est sur la page de modificationd e profil, on n'affiche pas le bouton
            if (!$pageNewAccount) { ?>
                <div id="BoutonModifierProfil" class="linkBox">
                    <a class="police" href="./newAccount.php">Modifier Profil</a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <div id="liste_users">
        <h3>Voici quelques joueurs</h3>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($users)) { // Boucle affichant tous les utilisateurs ?>
                <li><a href="./newAccount.php?util=<?php echo $row["id"]; ?>">
                    <img class="avatar" src="<?php echo $imagePathLink . $row["avatar"]; ?>">
                    <?php
                    if ($row["affichage_nom"] == 0) { // On affiche leur nom ou leur pseudo en fonction de leur choix
                        $utilNom = $row["pseudo"];
                    } else {
                        $utilNom = $row["prenom"] . " " . $row["nom"];
                    }
                    echo $utilNom;
                    ?>

                </a></li>
            <?php } ?>
        </ul>
    </div>

</div>