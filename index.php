<!-- index.php -->
<!-- Page d'accueil du site -->
<!-- La page d'accueil regroupe l'affichage d'un topic, de la recherche ou d'un jeu à travers différents include des fichiers présent dans le dossier PageParts/CentralDiv -->


<?php
// On démarre la session
session_start();

// On inclut les fichiers nécessaires notamment les variables et les fonctions
include('./PageParts/variables.php');
include('./functions/databaseFunctions.php');
include('./functions/accessFunctions.php');
include('./functions/searchFunctions.php');

// On se connecte à la base de données
connectDatabase();

// On initialise les variables
$type = "";             // Variable contenant le type de post à afficher (Topic, Message ou default)
$imageJeu = "";         // Variable contenant le chemin vers l'image du jeu
$nomJeu = "";           // Variable contenant le nom du jeu
$descriptionJeu = "";   // Variable contenant la description du jeu
$regles = "";           // Variable contenant le chemin vers les règles du jeu
$idJeu = -1;            // Variable contenant l'identifiant du jeu, par défaut -1
$idTopic = -1;          // Variable contenant l'identifiant du topic, par défaut -1

// On récupère le site courant et on le sauvegarde puisque la valeur de $site va être modifiée dans le header
$site = checkSite('index.php');
$siteCourant = $site;


// On identifie les parametres dans l'URL et on initialise les variables en fonction
if (isset($_GET['jeu'])) { // Si on a un jeu dans l'URL
    $idJeu = intval($_GET['jeu']);          // On récupère son identifiant en le convertissant en entier
    $jeu = getJeux($siteCourant, $idJeu);   // On récupère les informations du jeu

    if (!$jeu) { // Si le jeu n'existe pas
        // On affiche une alerte et on redirige vers la page d'accueil
        ?>
        <script>
            alert("Le jeu n'existe pas");
        </script>
        <?php
        header("Location: ./index.php?site=" . $site);
    } else { // Sinon
        // On initialise les variables avec les informations du jeu
        $nomJeu = $jeu['Nom'];
        $descriptionJeu = $jeu['Description'];
        $imageJeu = $imagesGamesPathLink . $jeu['image'];
        $regles = $rulesGamesPathLink . $jeu['regles'];

        // On indique que le type de post à afficher est un jeu
        $type = "Jeu";

        // et on récupère les topics du jeu
        $topics = getTopics($idJeu, "all");
    }
} else if (isset($_GET['topic'])) { // Si on a un topic dans l'URL
    $idTopic = intval($_GET['topic']);           // On récupère son identifiant en le convertissant en entier
    $topic = getTopics($idTopic, "one");    // On récupère les informations du topic

    if (!$topic) { // Si le topic n'existe pas
        // On affiche une alerte et on redirige vers la page d'accueil
        ?>
        <script>
            alert("Le topic n'existe pas");
        </script>

        <?php
        header("Location: ./index.php?site=" . $site);
    } else { // Sinon
        // On initialise les variables avec les informations du topic
        $nomTopic = $topic['titre'];
        $idJeu = $topic['jeux_id'];

        // On récupère les informations du jeu associé au topic
        $jeu = getJeux($siteCourant, $idJeu);
        $nomJeu = $jeu['Nom'];
        $imageJeu = $imagesGamesPathLink . $jeu['image'];
        $regles = $rulesGamesPathLink . $jeu['regles'];

        // On récupère les messages du topic (le premier et tous les autres)
        $firstMessage = getMessages($idTopic,"fist");
        $messages = getMessages($idTopic,"all");

        // On indique que le type de post à afficher est un topic
        $type = "Topic";
    }
} else { // Sinon
    // On récupère tous les topics
    $topics = getTopics(null, "all");

    // On indique que le type de post à afficher est default
    $type = "default";

}

// Si on a une recherche dans l'URL
if (isset($_GET['search'])) {
    // On récupère la recherche et on indique que le type de post à afficher est une recherche
    $search = $_GET['search'];
    $typeSearch = "";
    $searchResults = "";
    switch ($type) {
        case "Jeu":
            $typeSearch = "Jeu";
            break;
        case "Topic":
            $typeSearch = "Topic";
            break;
        case "default":
            $typeSearch = "All";
            break;
        default:
            break;
    }
    $type = "search";
}

?>

<!DOCTYPE html>

<html lang="fr">


<head>
    <!-- En-tête de la page -->
    <?php include('./PageParts/head.php'); ?>
</head>

<body>

    <!-- Bandeau du site contenant le nom du site, le moyen d'authentification et une barre de recherche -->

    <?php include('./PageParts/header.php'); ?>

    <!-- Reste de la page -->
    <div class="main_container">

        <!-- Colonne de gauche pour affichage des utilisateurs du site -->
        <?php include('./PageParts/users.php'); ?>

        <!-- Colonne centrale pour affichage du contenu -->
        <div class="container central deroulant">


            <?php
            // On affiche le contenu en fonction du type de post à afficher
            switch ($type) {
                case "Jeu": // Si c'est un jeu
                    include('./PageParts/CentralDiv/games.php');
                    break;
                case "Topic": // Si c'est un topic
                    include('./PageParts/CentralDiv/topic.php');
                    break;
                case "default": // Si c'est la page d'accueil
                    include('./PageParts/CentralDiv/default.php');
                    break;
                case "search": // Si c'est une recherche
                    include("./PageParts/CentralDiv/search.php");
                    break;
                default:
                    break;
            }
            ?>
        </div>

        <!-- Colonne de droite pour affichage des jeux proposés -->
        <?php include('./PageParts/proposedGames.php'); ?>

    </div>
</body>
</html>