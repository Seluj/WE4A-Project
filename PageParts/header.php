<?php
$typejeu = "Jeux Vidéos";


$connecte = false;
$nom = "";
$prenom = "";
$email = "";
$pseudo = "";
$avatar = "";
$affichage_nom = false;
$administrateur=false;

if(isset($_SESSION['id'])){
    $connecte = true;
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['mail'];
    $pseudo = $_SESSION['pseudo'];
    $avatar = $_SESSION['avatar'];
   if($_SESSION['affichage_nom'] == 0){
       $affichage_nom = false;
       $utilisateur = $pseudo;
   }else{
       $affichage_nom = true;
       $utilisateur = $prenom." ".$nom;
   }
    if($_SESSION['administrateur'] == 0){
        $administrateur = false;
    }else{
        $administrateur = true;
    }

}
?>

<header>

    <!-- Nom du site -->

    <h1 id="Nom_Site" class="police"><?php echo $nomsite ?></h1>

    <!-- Barre de recherche -->

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
                <a href="./newAccount.php" > <img src="<?php echo $littleImagePathLink."Meeple.png" ?>" alt="icone"> </a>
                <a class="police" href="./newAccount.php">Se Connecter</a>
            </div>
        <?php
        } else {
        ?>
             <!-- Bouton de déconnexion -->
            <div id="Deconnexion" class="linkBox">
                <a href="" > <img src="<?php echo $littleImagePathLink."Meeple.png" ?>" alt="icone"> </a>
                <a class="police" href="./stopSession.php">Se Déconnecter</a>
            </div>
        <?php
        }
        ?>
    </div>

</header>

<script>
    function addFile(){
        var file = document.getElementsByClassName("input_center");
        file.style.
    }
</script>