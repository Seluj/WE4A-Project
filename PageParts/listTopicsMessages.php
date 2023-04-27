<?php
if($type == "Topic"){
    $creer = "Créer Message";
    $liste = $messages;
    if ($connecte) {
        $lien = "./newMessage.php?topic=" . $idTopic;
    } else {
        $lien = "./newAccount.php";
    }
}else{
    $liste = $topics;
    $creer = "Créer Topic";
    if ($connecte) {
        $lien = "./newMessage.php?site=" . $siteCourant . "&jeu=" . $idJeu;
    } else {
        $lien = "./newAccount.php";
    }
}

if($type!="default"){ ?>
    <div class="BoutonCreerTopicMessage Boutons">
        <a class="police" href="<?php echo $lien ?>"><?php echo $creer ?></a>
    </div><br>
<?php } ?>



<?php if($liste != false){?>

    <h3><?php if($type=="Jeu"){ echo "Topics associés à ".$nomJeu; }else if($type=="Topic"){echo "Messages associés";}
        else{ echo "Voici quelques Topics récents :"; } ?></h3><br>

    <div id="topics_list" class="container_list">
        <ul>
            <?php while ($row = mysqli_fetch_assoc($liste)) {
                if($type != "default" || getJeux($siteCourant,$row["jeux_id"])["type"] == $siteCourant) {?>

                    <li id="one_topic" class="entrees">

                        <a href="./newAccount.php?site=<?php echo $siteCourant ?>&util=<?php echo getUsers($row["user_id"])["id"] ?>">
                            <img id="mini_image_avatar" class="mini_image" src="<?php echo $imagePathLink.getUsers($row["user_id"])["avatar"]?>"
                             alt="img" title="<?php echo getUsers($row["user_id"])["pseudo"]?>">
                        </a>

                        <?php if($type != "Topic"){ ?>
                            <a href="./index.php?site=<?php echo $siteCourant ?>&topic=<?php echo $row['id'] ?>">
                                <p class="titre_topic"><?php echo $row["titre"] ?></p>
                                <p class="message_topic"><?php echo getMessages($row["id"],"first")["contenu"] ?></p>
                            </a>
                        <?php } else {?>
                            <p class="message_topic"><?php echo $row["contenu"]; ?></p>
                        <?php }

                        if($type == "default"){ ?>
                            <a href="./index.php?site=<?php echo $siteCourant?>&jeu=
                            <?php echo getJeux($siteCourant,$row["jeux_id"])["id"] ?>">
                                <img id="mini_image_jeu" class="mini_image"
                                 src="<?php echo $imagesGamesPathLink.getJeux($siteCourant,$row["jeux_id"])["image"]?>"
                                 alt="img" title="<?php echo getJeux($siteCourant,$row["jeux_id"])["Nom"]?>">
                            </a>
                        <?php } ?>
                    </li><br>

                <?php }
            }?>
        </ul>
    </div>
<?php } else if($type=="Jeu"){?>
    <h3><?php echo "Aucun Topic associé à ".$nomJeu;?></h3>
<?php } ?>