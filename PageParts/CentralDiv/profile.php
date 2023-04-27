<?php $player=getUsers($_GET["util"]) ?>

<div class="container central deroulant">

    <img class="image_commentaire" src="<?php echo $littleImagePathLink."New_Player.png" ?>" alt="New Player !">
    <br>
    <h1 class="titre_interaction">Profil</h1>

    <img id="avatar_profil" class="avatar" src="<?php echo $imagePathLink . $player['avatar'] ?>" alt="avatar">

    <div class="container_list">

        <div class="entrees profil">
            <p><?php echo $player["prenom"] ?></p>
        </div>

        <br><br>
        <div class="entrees profil">
            <p><?php echo $player["nom"] ?></p>
        </div>

        <br><br>
        <div class="entrees profil">
            <p>Alias - <?php echo $player["pseudo"] ?></p>
        </div>

        <br><br>
        <div id="profil_user" class="entrees profil">
            <p>-- <?php echo $player["presentation"] ?> --</p>
        </div>

        <?php if ($administrateur) { ?>
            <br><br>
            <form class="entrees profil" method="post" action="#" enctype="multipart/form-data">

                <label for="administrateur">Administrateur</label>
                <input id="administrateur" class="input_center" name="administrateur" type="checkbox" <?php if ($player["administrateur"]) {echo "checked";} ?>>

                <input class="Boutons" type="submit" name="mettre_administrateur" value="Modifier" />
            </form>
        <?php } ?>
    </div><br>

    <div id="Revenir_accueil" class="Boutons">
        <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
    </div>
</div>