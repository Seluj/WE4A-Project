<?php
include("./PageParts/databaseFunctions.php");
include("./PageParts/variables.php");


session_start();
if(isset($_SESSION['id'])){
    header("Location: ./index.php");
}
?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <meta charset="UTF-8">
    <title><?php echo $nomsite ?></title>
    <link rel="stylesheet" href="./Styles/style.css">
    <link rel="icon" href="images/icone.png">
</head>

<body>

<!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

<?php include('./PageParts/header.php') ?>

<hr>
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
<hr>
<p><a href="./index.php" class="backlink"><< Revenir à l'accueil</a><br><br></p>

</body>
</html>