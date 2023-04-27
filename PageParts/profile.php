<?php $player=getUsers($_GET["util"]) ?>

<div class="container central deroulant">

    <img class="image_commentaire" src="<?php echo $littleImagePathLink."New_Player.png" ?>" alt="New Player !">
    <br>
    <h1 class="titre_interaction">Profil</h1>

    <img id="avatar_profil" class="avatar" src="<?php echo $imagePathLink . $player['avatar'] ?>" alt="avatar">

    <div class="container_list">


        <div class="entrees profil">
            <p><?php echo $player["nom"] ?></p>
        </div>

        <br><br>
        <div class="entrees profil">
            <p><?php echo $player["prenom"] ?></p>
        </div>

        <br><br>
        <div class="entrees profil">
            <p><?php echo $player["pseudo"] ?></p>
        </div>
        <br><br>
    </div>

    <div id="Revenir_accueil" class="linkBox">
        <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
    </div>
</div>