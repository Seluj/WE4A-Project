<!-- PageParts/header.php -->
<!-- Fichier contenant toutes les informations du bandeau du site et attribuant des variables nécessaires au reste du site -->


<?php

global $siteCourant;

// Variables nécessaires au reste du site
$typeJeu = "";              // Type de jeu (Jeux Vidéos ou Jeux de Société)
$id_user="";                // ID de l'utilisateur connecté
$connecte = false;          // Booléen indiquant si l'utilisateur est connecté, par défaut à false
$nom = "";                  // Nom de l'utilisateur connecté
$prenom = "";               // Prénom de l'utilisateur connecté
$email = "";                // Email de l'utilisateur connecté
$pseudo = "";               // Pseudo de l'utilisateur connecté
$presentation="";           // Présentation de l'utilisateur connecté
$avatar = "";               // Avatar de l'utilisateur connecté, il contient le chemin intégral vers l'image
$affichage_nom = false;     // Booléen indiquant si l'utilisateur souhaite afficher son nom, par défaut à false
$administrateur = false;    // Booléen indiquant si l'utilisateur est administrateur, par défaut à false
$jeux = "";                 // Liste des jeux du site
$jeuxVisites = "";          // Liste des jeux visités par l'utilisateur

// Verifie si l'utilisateur est connecté
if (isset($_SESSION['id'])) { // Si l'utilisateur est connecté
    // On récupère les informations de l'utilisateur
    $connecte = true;
    $id_user = $_SESSION['id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['mail'];
    $pseudo = $_SESSION['pseudo'];
    $presentation = $_SESSION['presentation'];
    $avatar = $imagePathLink . $_SESSION['avatar'];
   if ($_SESSION['affichage_nom'] == 0) {
       $utilisateur = $pseudo;
   } else {
       $affichage_nom = true;
       $utilisateur = $prenom . " " . $nom;
   }
    if ($_SESSION['administrateur'] != 0) {
        $administrateur = true;
    }
}

// Vérifie si la variable site est bien renseignée dans l'URL, sinon on la met à -1
$site = $_GET['site'] ?? -1;

// Modifie la variable site en fonction de la valeur de la variable site actuelle pour pouvoir changer de site
switch ($site) {
    case -1:
        break;
    case 0:
        $site = 1;
        $typeJeu = "Jeux Vidéos";
        break;
    case 1:
        $site = 0;
        $typeJeu = "Jeux de Société";
        break;
    default:
        $site = 0;
        break;
}

// On récupère la liste des jeux et des jeux visités par l'utilisateur si le site courant est renseigné
if (isset($siteCourant)) {
    $jeux = getJeux($siteCourant);
    $jeuxVisites = getJeux($siteCourant, (int)$id_user, true);
}
// On récupère la liste des utilisateurs
$users = getUsers();

if ($siteCourant) {       // Permet de choisir l'icône à afficher dans le header en fonction du type de jeu courant
    $icone = "background-image: url(./images/carte.png)";
} else {
    $icone = "background-image: url(./images/manette.png)";
}
?>

<header>

    <!-- Nom du site -->

    <a href="./index.php?site=<?php echo $siteCourant; ?>"><h1 id="Nom_Site" class="police"><?php echo $nomSite; ?></h1></a>

    <!-- Barre de recherche -->

    <div id="formulaires">

        <?php if ($site != -1) { ?>
        <p id="Direction"> Vers <?php echo $typeJeu; ?> </p>
        <form id="Changement_jeu" action="" method="get">

            <input type="hidden" name="site" value="<?php echo $site; ?>">
            <input type="submit" style="<?php echo $icone ?>" value="">
        </form>
        <?php } ?>
        <form id="Recherche_generale" action="./index.php" method="get">
            <?php
            $keys = array('site', 'topic', 'jeu', 'message');
            foreach ($keys as $name) {
                if (!isset($_GET[$name])) {
                    continue;
                }
                $value = htmlspecialchars($_GET[$name]);
                $name = htmlspecialchars($name);
                echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
            }
            ?>
            <input class="saisie" type="text" name="search" placeholder="Rechercher">
            <input type="submit" style="background-image: url(./images/Loupe.png)" value="">
        </form>


        <?php
        if (!isset($_SESSION['id'])) {
        ?>
            <!-- Bouton de connexion -->
            <div id="Connexion" class="linkBox">
                <a href="./newAccount.php" > <img src="<?php echo $littleImagePathLink . "Meeple.png"; ?>" alt="icone"> </a>
                <a class="police" href="./newAccount.php">Se Connecter</a>
            </div>
        <?php
        } else {
        ?>
             <!-- Bouton de déconnexion -->
            <div id="Deconnexion" class="linkBox">
                <a href="" > <img src="<?php echo $littleImagePathLink . "Meeple.png"; ?>" alt="icone"> </a>
                <a class="police" href="./stopSession.php">Se Déconnecter</a>
            </div>
        <?php
        }
        ?>
    </div>
</header>