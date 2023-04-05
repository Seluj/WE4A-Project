<?php
include("./PageParts/databaseFunctions.php");
include("./PageParts/variables.php");

session_start();
$connecte = false;
$nom = "";
$prenom = "";
$email = "";
$pseudo = "";
$avatar = "";
$affichage_nom = "";

if(isset($_SESSION['id'])){
    $connecte = true;
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['mail'];
    $pseudo = $_SESSION['pseudo'];
    $avatar = $_SESSION['avatar'];
    $affichage_nom = $_SESSION['affichage_nom'];
}
ConnectDatabase();
checkAccount();
?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <meta charset="UTF-8">
    <title><?php echo $nomsite ?></title>
    <link rel="stylesheet" href="./Styles/style.css">
    <link rel="stylesheet" href="./Styles/header.css">
    <link rel="stylesheet" href="./Styles/interaction.css">
    <link rel="icon" href="images/icone.png">
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php') ?>

    <div class="main_container main_interaction_container">
        <?php
        include("./PageParts/signinForm.php");
        include("./PageParts/loginForm.php");
        ?>
        <script>
            window.onload = function() {
                var log = document.getElementById("login");
                var sign = document.getElementById("signin");
                log.style.display = "block";
                sign.style.display = "none";
            }
            function myFunction() {
                var log = document.getElementById("login");
                var sign = document.getElementById("signin");
                if (log.style.display === "none") {
                    log.style.display = "block";
                    sign.style.display = "none";
                } else {
                    log.style.display = "none";
                    sign.style.display = "block";
                }
            }
        </script>

        <div id="Revenir_accueil" class="linkBox">
            <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
        </div>
    </div>
</body>
</html>