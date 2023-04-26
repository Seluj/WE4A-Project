<?php


if($topics != false){?>
    <h3><?php if($type=="Jeu"){ echo "Topics associés à ".$nomJeu; }else{ echo "Quelques Topics"; } ?></h3>
    <div id="topics_list" class="container_list">
        <ul>
            <?php while ($row = mysqli_fetch_assoc($topics)) { ?>

                <li id="one_topic" class="entrees">

                    <img id="mini_image_avatar" class="mini_image" src="<?php echo $imagePathLink.getUsers($row["user_id"])["avatar"]?>"
                         alt="img" title="<?php echo getUsers($row["user_id"])["pseudo"]?>">

                    <a href="./index.php?site=<?php echo $siteCourant ?>&topic=<?php echo $row['id'] ?>">
                        <p class="titre_topic"><?php echo $row["titre"] ?></p>
                        <p class="message_topic"><?php echo getMessages($row["id"],"first")["contenu"] ?></p>
                    </a>
                    <?php if($type != "Jeu"){ ?>
                        <img id="mini_image_jeu" class="mini_image"
                             src="<?php echo $imagesGamesPathLink.getJeux($siteCourant,$row["jeux_id"])["image"]?>"
                             alt="img" title="<?php echo getJeux($siteCourant,$row["jeux_id"])["Nom"]?>">
                    <?php } ?>
                </li><br>

            <?php } ?>
        </ul>
    </div>
<?php } else if($type=="Jeu"){?>
    <h3><?php echo "Aucun Topic associé à ".$nomJeu;?></h3>
<?php } ?>