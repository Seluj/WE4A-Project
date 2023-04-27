<?php
include("./functions/databaseFunctions.php");
include("./functions/searchFunctions.php");

connectDatabase();

$postNumber = $_GET["firstPost"];
$search = $_GET["search"];

switch ($_GET["typeSearch"]) {
    case "jeu":
        $idJeu = $_GET["jeu"];
        $searchResults = searchInGame($idJeu, $search, $postNumber);
        break;
    case "topic":
        $idTopic = $_GET["topic"];
        $searchResults = searchInTopic($idTopic, $search, $postNumber);
        break;
    default:
        $searchResults = searchInAll($search, $postNumber);
        break;
}

if ($searchResults) {
    while ($row = mysqli_fetch_assoc($searchResults)) {
        ?>
        <li id="one_topic" class="entrees"><a>
                <p class="titre_topic"><?php echo $row["Nom"] . '<br>'. $row["titre"] . '<br>'. $row['contenu'];?></p>
            </a></li><br>
        <?php
        $postNumber++;
    }
    if ($postNumber % 5 == 0)
        echo '<div id="morePosts" class="center">
                <button type="button" onclick="loadMorePosts('.$postNumber.')">Charger plus de Posts</button>
            </div>';
} else {
    echo "<h1>Aucun résultat pour la recherche : $search</h1>";
}

