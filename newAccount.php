<?php
include("./PageParts/variables.php");
include("./functions/databaseFunctions.php");
include("./functions/accountFunctions.php");

session_start();

ConnectDatabase();
checkAccount();

$PagenewAccount = true;
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

    <div class="main_container">
        <?php include('./PageParts/profile.php') ?>
        <?php include('./PageParts/signinForm.php') ?>
        <?php include('./PageParts/loginForm.php') ?>
        <script>
            window.onload = function(){
                FunctionReturnConnect();
            }

            function FunctionReturnConnect(){
                var log = document.getElementById("login");
                var sign = document.getElementById("signin");
                var connecte = <?php echo json_encode($connecte); ?>;

                if(connecte){
                    log.style.display = "none";
                    sign.style.display = "inline";
                }else{
                    log.style.display = "inline-block";
                    sign.style.display = "none";
                }

            }
            function FunctionInscription() {
                var log = document.getElementById("login");
                var sign = document.getElementById("signin");

                log.style.display = "none";
                sign.style.display = "inline-block";

            }
        </script>

        <?php include('./PageParts/games.php') ?>
    </div>

</body>
</html>
<?php $PagenewAccount = false;?>