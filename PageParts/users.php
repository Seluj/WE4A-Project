<div id="utilisateurs" class="container">
    <?php if ($connecte) {?>
        <div id="profil">
            <h1><a href="">Profil</a></h1>
            <div>
                <img class="avatar" src="<?php echo $imagePathLink . $_SESSION['avatar'] ?>" alt="avatar">
                <h2><?php echo $utilisateur ?></h2>
            </div>
            <div>
                <?php echo "Hello c'est moi" ?>
            </div>
            <?php if (!$pageNewAccount) { ?>
                <div id="BoutonModifierProfil" class="linkBox">
                    <a class="police" href="./newAccount.php">Modifier Profil</a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <ul>
        <?php while ($row = mysqli_fetch_assoc($users)) { ?>
            <li><a href="./newAccount.php?site=<?php echo $siteCourant ?>&util=<?php echo $row["id"] ?>">
                <img class="avatar" src="<?php echo $imagePathLink . $row['avatar'] ?>">
                <?php if ($row["affichage_nom"] == 0) {
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