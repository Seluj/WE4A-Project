<?php $player=getUsers($_GET["util"]) ?>

<div class="container central">

    <img class="image_commentaire" src="<?php echo $littleImagePathLink."New_Player.png" ?>" alt="New Player !">
    <br>
    <h1 class="titre_interaction">Profil</h1>


    <div class="container_list">

        <img class="avatar" src="<?php echo $imagePathLink . $player['avatar'] ?>" alt="avatar">

        <div class="entrees">
            <p><?php echo $player["nom"] ?></p>
        </div>

        <br><br>
        <div class="entrees">
            <p><?php echo $player["prenom"] ?></p>
        </div>

        <br><br>
        <div class="entrees">
            <p><?php echo $player["pseudo"] ?></p>
        </div>
        <br><br>
    </div>

    <div id="Revenir_accueil" class="linkBox">
        <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
    </div>
</div>