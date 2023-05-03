<!-- loadMore.php -->
<!-- Fichier contenant l'affichage de posts supplémentaires lorsqu'un utilisateur clique sur le bouton "Charger plus de posts" -->


<?php
// On inclut les fichiers nécessaires
include("./functions/databaseFunctions.php");
include("./functions/searchFunctions.php");

// On se connecte à la base de données
connectDatabase();

// On récupère les paramètres de l'URL
$postNumber = $_GET["firstPost"];   // Variable contenant l'offset
$search = $_GET["search"];          // Variable contenant l'élément à rechercher

// On initialise la variable contenant les résultats de la recherche en fonction du type de recherche
switch ($_GET["typeSearch"]) {
    case "jeu": // Si on recherche dans un jeu
        $idJeu = $_GET["jeu"];
        $searchResults = searchInGame($idJeu, $search, $postNumber);
        break;
    case "topic": // Si on recherche dans un topic
        $idTopic = $_GET["topic"];
        $searchResults = searchInTopic($idTopic, $search, $postNumber);
        break;
    default: // Recherche par défaut
        $searchResults = searchInAll($search, $postNumber);
        break;
}

if ($searchResults) { // Si on a des résultats
    // On affiche les résultats un par un
    while ($row = mysqli_fetch_assoc($searchResults)) {
        ?>
        <li id="one_topic" class="entrees"><a>
                <p class="titre_topic"><?php echo $row["Nom"] . '<br>'. $row["titre"] . '<br>'. $row['contenu'];?></p>
            </a></li><br>
        <?php
        // On incrémente le nombre de posts pour la prochaine requête
        $postNumber++;
    }
    if ($postNumber % 5 == 0) // Si on a 5 posts, on affiche le bouton "Charger plus de posts" pour afficher les suivants
        echo '<div id="morePosts" class="center">
                <button type="button" onclick="loadMorePosts('.$postNumber.')">Charger plus de Posts</button>
            </div>';
    else
        echo '<h1>Plus de post</h1>';
} else {
    echo "<h1>Aucun résultat pour la recherche : $search</h1>";
}

