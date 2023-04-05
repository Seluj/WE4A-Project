<div id="utilisateurs" class="container">
    <?php if($connecte){?>
        <div id="profil">
            <h1><a href="">Profil</a></h1>
            <div>
                <img class="avatar" src="<?php echo $imagePathLink.$_SESSION['avatar'] ?>" alt="avatar">
                <h2><?php echo $utilisateur ?></h2>
            </div>
            <div>
                <?php echo "Hello c'est moi" ?>
            </div>
        </div>
    <?php } ?>

    <ul>
        <?php boucle("Utilisateur", 20) ?>
    </ul>
</div>