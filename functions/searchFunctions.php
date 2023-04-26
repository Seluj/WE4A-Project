<?php

/**
 * Elle exécute une requête SQL pour chercher dans les colonnes "contenu" des messages et "titre" des topics associés au jeu spécifié.
 * Si la requête retourne des résultats, la fonction retourne un objet mysqli_result contenant les données de la recherche.
 * Sinon, la fonction retourne false.
 * @param string $idJeu L'id du jeu dans lequel on veut rechercher
 * @param string $search Objet de la recherche
 * @return false|mysqli_result Retourne le résultat de la requête ou false si aucun résultat
 */
function searchInGame(string $idJeu, string $search): bool|mysqli_result
{
    // Convertit l'id du jeu en entier pour éviter les injections SQL
    $idJeu = intval($idJeu);

    // Récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // Construit la requête SQL pour chercher dans les messages et les topics
    $query = "SELECT `messages`.*, `topics`.*
            FROM `messages`
            INNER JOIN `topics` ON `messages`.`topics_id` = `topics`.`id`
            WHERE `topics`.`jeux_id` = $idJeu AND (`messages`.`contenu` LIKE '%$search%' OR `topics`.`titre` LIKE '%$search%')";

    // Exécute la requête et vérifie qu'elle a bien fonctionné
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        // Si la requête a retourné des résultats, retourne l'objet mysqli_result
        return $result;
    } else {
        // Sinon, retourne false
        return false;
    }
}

/**
 * Fonction permettant de rechercher dans un topic les messages contenant la recherche
 * @param string $idTopic L'id du topic dans lequel on veut rechercher
 * @param string $search Objet de la recherche
 * @return false|mysqli_result Retourne le résultat de la requête ou false si aucun résultat
 */
function searchInTopic(string $idTopic, string $search): bool|mysqli_result
{
    // Convertit l'id du topic en entier pour éviter les injections SQL
    $idTopic = intval($idTopic);

    // Récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // Construit la requête SQL pour chercher dans les messages
    $query = "SELECT *
            FROM `messages`
            WHERE `messages`.`topics_id` = $idTopic AND `messages`.`contenu` LIKE '%$search%'";

    // Exécute la requête et vérifie qu'elle a bien fonctionné
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        // Si la requête a retourné des résultats, retourne l'objet mysqli_result
        return $result;
    } else {
        // Sinon, retourne false
        return false;
    }
}

/**
 * Fonction permettant de rechercher partout dans la base de données les jeux, topics et messages contenant la recherche
 * @param string $search Objet de la recherche
 * @return false|mysqli_result Retourne le résultat de la requête ou false si aucun résultat
 */
function searchInAll(string $search): bool|mysqli_result
{
    // Récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // Construit la requête SQL pour chercher dans les jeux, topics et messages
    $query = "SELECT `jeux`.*, `topics`.*, `messages`.*
            FROM `jeux`
            INNER JOIN `topics` ON `jeux`.`id` = `topics`.`jeux_id`
            INNER JOIN `messages` ON `topics`.`id` = `messages`.`topics_id`
            WHERE `jeux`.`Nom` LIKE '%$search%' OR `topics`.`titre` LIKE '%$search%' OR `messages`.`contenu` LIKE '%$search%'";

    // Exécute la requête et vérifie qu'elle a bien fonctionné
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        // Si la requête a retourné des résultats, retourne l'objet mysqli_result
        return $result;
    } else {
        // Sinon, retourne false
        return false;
    }
}
?>