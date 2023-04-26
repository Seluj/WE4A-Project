<div id="default_div">
    <img id="image_titre" src="./images/fond_titre.png" alt="Bienvenue">
    <?php if(!$connecte){ ?>
        <p class="texte_accueil">Venez vous plongez avec nous dans le monde des jeux de société et des jeux vidéos ! Vous souhaitez découvrir de
            nouveaux jeux, discuter stratégie et partager vos expériences de jeu avec d'autres passionnés dans un monde de
            divertissement et de compétition ? Notre communauté dynamique est l'endroit idéal pour les joueurs occasionnels
            et les compétiteurs chevronnés pour participer à des discussions animées, pour poser des questions et aider les
            autres joueurs en répondant aux leurs.
            Vous avez la possibilité de créer des topics à propos de jeux, d'y échanger avec les autres utilisateurs
            au travers de messages, et de participer à des topics créés par d'autres. </p>
    <?php }else{ ?>
        <p class="texte_accueil">Bienvenue <b><?php echo $utilisateur ?></b> ! <br><br>Découvre ici de nouveaux jeux ! Quelques-uns te sont proposés
            dans la section "<?php echo $nomSectionJeux ?>", mais si tu en cherches un en particulier, utilise la barre de recherche dans le
            bandeau supérieur.<br>Tu peux également y choisir le type de jeux qui te sont proposés !<br>Si tu as une question ou souhaites discuter
            d'un aspect d'un jeu avec d'autres personnes, il te suffit d'aller sur la page du jeu et de créer un topic sur le sujet, et tout le monde
            pourra venir y participer !</p>

    <?php }
    include("./PageParts/listTopicsMessages.php") ?>

</div>
