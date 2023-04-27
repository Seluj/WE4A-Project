<?php
global $siteCourant;
$typeJeu = "";
$id_user="";
$connecte = false;
$nom = "";
$prenom = "";
$email = "";
$pseudo = "";
$presentation="";
$avatar = "";
$affichage_nom = false;
$administrateur = false;


if (isset($_SESSION['id'])) {
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

$site = $_GET['site'] ?? -1;

switch ($site) {
    case -1:
        break;
    case 0:
        $site = 1;
        //$imagetype = "images/icone.png";
        $typeJeu = "Jeux Vidéos";
        break;
    case 1:
        $site = 0;
        //$imagetype = "images/icone.png";
        $typeJeu = "Jeux de Société";
        break;
    default:
        $site = 0;
        break;
}

$jeux = "";
$jeuxVisites = "";

if (isset($siteCourant)) {
    $jeux = getJeux($siteCourant);
    $jeuxVisites = getJeux($siteCourant, (int)$id_user, true);
}
$users = getUsers();
?>

<header>

    <!-- Nom du site -->

    <a href="./index.php?site=<?php echo $siteCourant ?>"><h1 id="Nom_Site" class="police"><?php echo $nomSite ?></h1></a>

    <!-- Barre de recherche -->

    <div id="formulaires">

        <?php
        if ($site != -1) {
        ?>
        <p id="Direction"> Vers <?php echo $typeJeu?> </p>
        <form id="Changement_jeu" action="" method="get">

            <input type="hidden" name="site" value="<?php echo $site;?>">
            <input type="submit" style="background-image: url(./images/Loupe.png)" value="">
        </form>
        <?php
        }
        ?>
        <form id="Recherche_generale" action="./index.php" method="get">
            <?php
            $keys = array('site', 'topic', 'jeu', 'message');
            foreach($keys as $name) {
                if(!isset($_GET[$name])) {
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
                <a href="./newAccount.php" > <img src="<?php echo $littleImagePathLink . "Meeple.png" ?>" alt="icone"> </a>
                <a class="police" href="./newAccount.php">Se Connecter</a>
            </div>
        <?php
        } else {
        ?>
             <!-- Bouton de déconnexion -->
            <div id="Deconnexion" class="linkBox">
                <a href="" > <img src="<?php echo $littleImagePathLink . "Meeple.png" ?>" alt="icone"> </a>
                <a class="police" href="./stopSession.php">Se Déconnecter</a>
            </div>
        <?php
        }
        ?>
    </div>
</header>