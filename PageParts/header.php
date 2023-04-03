<?php
$typejeu = "Jeux Vidéos";
?>

<header>

    <!-- Nom du site -->

    <h1 id="Nom_Site"><?php echo $nomsite ?></h1>

    <!-- Barre de recherche -->

    <!-- <form action="#" method="post">
        <input type="submit" value="Jeu">
    </form> -->

    <div id="formulaires">

        <p id="Direction"> Vers <?php echo $typejeu?> </p>
        <form id="Changement_jeu" action="#" method="post">
                <input type="image" src="<?php echo $imagetype ?>" alt="icone">
        </form>

        <form id="Recherche_generale" action="#" method="post">
            <input class="saisie" type="text" name="recherche" placeholder="Rechercher">
            <input type="image" src="images/Loupe.png" alt="icone">
        </form>


        <?php
        if (!isset($_SESSION['id'])) {
        ?>
        <!-- Bouton de connexion -->
        <div id="Connexion" class="linkBox">
            <a href="./newAccount.php" > <img src="images/Meeple.png" alt="icone"> </a>
            <a id="se_connecter" class="link" href="./newAccount.php">Se Connecter</a>
        </div>
        <?php
        } else {
        ?>
         <!-- Bouton de déconnexion -->
        <div id="Deconnexion" class="linkBox">
            <a href="" > <img src="<?php echo $_SESSION['avatar'] ?>" alt="icone"> </a>
            <a href="./stopSession.php">Se Déconnecter</a>
        </div>
        <?php
        }
        ?>
    </div>


</header>