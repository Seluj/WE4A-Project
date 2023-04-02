<?php
session_start();
?>

<header>

    <!-- Nom du site -->

    <h1 id="Nom_Site" class="police"><?php echo $nomsite ?></h1>

    <!-- Barre de recherche -->

    <!-- <form action="#" method="post">
        <input type="submit" value="Jeu">
    </form> -->

    <form id="Recherche_generale" action="#" method="post">
        <input type="text" name="recherche" placeholder="Rechercher">
        <input type="image" src="images/Loupe.png" alt="icone">
    </form>


    <?php
    if (!isset($_SESSION['id'])) {
    ?>
    <!-- Bouton de connexion -->
    <div id="Connexion">
        <a href="" > <img src="images/Meeple.png" alt="icone"> </a>
        <a class="police" href="">Se Connecter</a>
    </div>
    <?php
    } else {
    ?>
     <!-- Bouton de déconnexion -->
    <div id="Deconnexion">
        <a href="" > <img src="<?php $_SESSION['avatar'] ?>>" alt="icone"> </a>
        <a class="police" href="">Se Déconnecter</a>
    </div>
    <?php
    }
    ?>


</header>