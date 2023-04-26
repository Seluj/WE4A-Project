<?php
include("./PageParts/variables.php");
include("./functions/databaseFunctions.php");
include("./functions/accountFunctions.php");
include("./functions/accessFunctions.php");

session_start();

connectDatabase();
checkAccount();

$pageNewAccount = true;

$site = checkSite('newAccount.php');
$siteCourant = $site;
$util = 0;
$util = $_GET["util"];

?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <?php include('./PageParts/head.php') ?>
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php') ?>

    <div class="main_container">

        <?php include('./PageParts/users.php');

        if($util != 0) {
            include('./PageParts/profile.php');
        }else{
            include('./PageParts/signinForm.php');
            include('./PageParts/loginForm.php') ?>
        <script>
            window.onload = function() {
                FunctionReturnConnect();
            }

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

            function FunctionInscription() {
                const log = document.getElementById("login");
                const sign = document.getElementById("signin");

                log.style.display = "none";
                sign.style.display = "inline-block";
            }
        </script>

        <?php }

        include('./PageParts/proposedGames.php') ?>

    </div>

</body>
</html>
<?php $pageNewAccount = false;?>