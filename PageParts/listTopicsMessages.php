<!-- PageParts/listTopicsMessages.php -->
<!-- Fichier permettant l'affichage d'une liste de messages ou de topics -->


<?php
$creer = ""; // Variable contenant l'affichage du bouton de création de message / topic
$liste = ""; // Variable contenant les listes d'éléments à afficher

// Initialisation des variables en fonction du type de post à créer
if ($type == "Topic") {   // Si on est dans un topic...

    $creer = "Créer Message";   // Le bouton de création doit afficher "Créer Message"
    $liste = $messages;         // La liste d'éléments contient des messages
    //
    if ($connecte) {                                        // Si un utilisateur est connecté...
        $lien = "./newMessage.php?topic=" . $idTopic;       // ...le bouton de création le dirige vers la bonne page
    } else {
        $lien = "./newAccount.php";                         // ...sinon on le dirige vers la page de connexion
    }

} else {                   // ... sinon, on est dans un jeu...

    $creer = "Créer Topic"; // Le bouton de création doit afficher "Créer Topic"
    $liste = $topics;       // La liste d'éléments contient des topics
    //
    if ($connecte) {           // Si un utilisateur est connecté...
                               // ...le bouton de création le dirige vers la bonne page
        $lien = "./newMessage.php?site=" . $siteCourant . "&jeu=" . $idJeu;
    } else {
        $lien = "./newAccount.php";   // ...sinon on le dirige vers la page de connexion
    }
}


if ($type != "default") {     // On affiche le bouton de création lorsque l'on est dans un jeu ou un topic,
                            // mais pas dans le cas de l'affichage des topics dans la page d'accueil

    // On affiche alors le bouton de création de topic ou message avec l'intitulé et le lien correspondant ?>
    <div id="contientBouton">
        <div class="BoutonCreerTopicMessage Boutons">
            <a class="police" href="<?php echo $lien; ?>"><?php echo $creer; ?></a>
        </div>
    </div>

<?php } ?>



<?php if ($liste) {  // Si la liste n'est pas vide on peut afficher les éléments de la liste

    // On donne le bon intitulé au titre de la page ?>

    <h3><?php if ($type == "Jeu") {            // Si c'est un jeu, le titre doit être le suivant
        echo "Topics associés à " . $nomJeu;
    }
    else if ($type=="Topic") {                // Si c'est un topic, il doit être "Messages associés"
        echo "Messages associés";
    } else {
        echo "Voici quelques Topics récents :";  // Sinon on est dans la page d'accueil
    } ?>
    </h3><br>

    <div id="topics_list" class="container_list"> <!-- Conteneur de la liste -->
        <ul>
            <?php while ($row = mysqli_fetch_assoc($liste)) {  // Boucle pour chaque élément de la liste

                if($type != "default" || getJeux($siteCourant,$row["jeux_id"])["type"] == $siteCourant) {
                // On n'affiche pas les éléments de la liste si on se trouve sur la page d'accueil et que
                // leur type ne correspond pas au type courant (vidéo / société) ?>

                    <li id="one_topic" class="entrees"> <!-- Conteneur d'un élément de la liste -->

                        <!-- Image de l'avatar de l'utilisateur ayant posté le topic / message
                         avec un lien redirigeant vers sa page de profil-->
                        <a href="./newAccount.php?site=<?php echo $siteCourant; ?>&util=<?php echo getUsers($row["user_id"])["id"]; ?>">
                            <img id="mini_image_avatar" class="mini_image" src="<?php echo $imagePathLink . getUsers($row["user_id"])["avatar"]; ?>"
                             alt="img" title="<?php echo getUsers($row["user_id"])["pseudo"]?>">
                        </a>


                        <?php if($type != "Topic"){ // Si on est dans un jeu ou dans la page d'accueil, on liste des topics...

                            //...  affiche le titre du topic et son premier message associé ?>
                            <a href="./index.php?site=<?php echo $siteCourant; ?>&topic=<?php echo $row['id']; ?>">
                                <p class="titre_topic"><?php echo $row["titre"]; ?></p>
                                <p class="message_topic"><?php echo getMessages($row["id"],"first")["contenu"]; ?></p>
                            </a>

                        <?php } else {
                            //...sinon on liste des messages, on n'affiche donc qu'un message?>
                            <p class="message_topic"><?php echo $row["contenu"]; ?></p>
                        <?php }

                        //Si on est sur la page d'accueil, on affiche une image du jeu lié au topic courant;
                        // avec un lien dirigeant vers la page du jeu
                        if($type == "default"){ ?>

                            <a href="./index.php?site=<?php echo $siteCourant; ?>&jeu=
                            <?php echo getJeux($siteCourant,$row["jeux_id"])["id"]; ?>">
                                <img id="mini_image_jeu" class="mini_image"
                                 src="<?php echo $imagesGamesPathLink . getJeux($siteCourant,$row["jeux_id"])["image"]; ?>"
                                 alt="img" title="<?php echo getJeux($siteCourant,$row["jeux_id"])["Nom"]; ?>">
                            </a>
                        <?php } ?>
                    </li><br>

                <?php }
            } ?>
        </ul>
    </div>
<?php } else if ($type == "Jeu") {  // Si la liste d'élément est vide et que l'on est dans un jeu,
                                    // on affiche l'annonce suivante :?>
    <h3><?php echo "Aucun Topic associé à " . $nomJeu; ?></h3>
<?php } ?>