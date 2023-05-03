<!-- newAccount.php -->
<!-- Fichier contenant l'affichage de la page de création de compte -->


<?php

// On démarre la session
session_start();

// On inclut les fichiers nécessaires
include("./PageParts/variables.php");
include("./functions/databaseFunctions.php");
include("./functions/accountFunctions.php");
include("./functions/accessFunctions.php");

// On se connecte à la base de données
connectDatabase();

// On initialise les variables
$pageNewAccount = true;                     // Variable indiquant que l'on est sur la page de création de compte
$util = -1;                                 // Variable contenant l'identifiant d'un autre utilisateur, par défaut -1

// On récupère le site courant et on le sauvegarde puisque la valeur de $site va être modifiée dans le header
$site = checkSite('newAccount.php');
$siteCourant = $site;

if (isset($_GET["util"])) { // Si on a un utilisateur dans l'URL
    // On récupère son identifiant
    $util = $_GET["util"];
}

// On lance la fonction qui permet de vérifier et de procéder à la création d'un compte, la connexion, la modification du compte ou la modification du champ administrateur
checkAccount($util);
?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <!-- En-tête de la page -->
    <?php include('./PageParts/head.php') ?>
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php') ?>

    <!-- Reste de la page -->
    <div class="main_container">

        <!-- Colonne de gauche pour affichage des utilisateurs du site -->
        <?php include('./PageParts/users.php');

        // Colonne centrale pour affichage du contenu
        if ($util != -1) { // Si on a un utilisateur dans l'URL
            // On affiche son profil
            include('./PageParts/CentralDiv/profile.php');
        } else { // Sinon,
            // On inclut les deux formulaires (connexion et inscription) et on modifie l'affichage à l'aide de javascript
            include('./PageParts/signinForm.php');
            include('./PageParts/loginForm.php') ?>
            <!-- Script d'alternance entre les formulaires -->
            <script>
                window.onload = function() {
                    FunctionReturnConnect();
                }

                // Fonction permettant d'afficher le formulaire de connexion
                function FunctionReturnConnect() {
                    const log = document.getElementById("login");
                    const sign = document.getElementById("signin");
                    let connecte = <?php echo json_encode($connecte); ?>;

                    if (connecte) {
                        log.style.display = "none";
                        sign.style.display = "inline";
                    } else {
                        log.style.display = "inline-block";
                        sign.style.display = "none";
                    }
                }

                // Fonction permettant d'afficher le formulaire d'inscription
                function FunctionInscription() {
                    const log = document.getElementById("login");
                    const sign = document.getElementById("signin");

                    log.style.display = "none";
                    sign.style.display = "inline-block";
                }
            </script>

        <?php
        }

        include('./PageParts/proposedGames.php');
        ?>

    </div>

</body>
</html>
<?php $pageNewAccount = false; ?>