<?php

/**
 * @param $id
 * @param $type
 * @return bool|mysqli_result|array
 */
function getMessages($id, $type): bool|mysqli_result|array
{
    $id = intval($id);

    global $conn;

    if ($type == "all") {
        $query = "SELECT * FROM `messages` 
                WHERE `messages`.`topics_id` = '$id'";
    } else if ($type == "first") {
        $query = "SELECT * FROM `messages` 
                WHERE `messages`.`topics_id` = '$id' 
                ORDER BY `messages`.`id` ASC 
                LIMIT 1";
    } else {
        return false;
    }

    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        if ($type == "first") {
            return mysqli_fetch_assoc($result);
        }
        return $result;
    } else {
        return false;
    }
}

// Fonction permettant de récupérer un topic ou l'ensemble des topics d'un jeu

/**
 * @param $id
 * @param $type
 * @return bool|mysqli_result|array
 */
function getTopics($id, $type): bool|mysqli_result|array
{
    $id = intval($id);

    global $conn;

    if ($type == "all") {
        if ($id == null) {
            $query = "SELECT `topics`.*
                    FROM `topics`
                    ORDER BY `topics`.`date_edit` DESC";
        } else {
            $query = "SELECT * FROM `topics` 
                    WHERE `topics`.`jeux_id` = '$id' 
                    ORDER BY `topics`.`date_edit` DESC";
        }
    } else if ($type == "one") {
        $query = "SELECT * FROM `topics` 
                WHERE `topics`.`id` = '$id'";
    } else {
        return false;
    }
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        if ($type == "one") {
            return mysqli_fetch_assoc($result);
        }
        return $result;
    } else {
        return false;
    }
}

// Fonction permettant de récupérer un jeu ou l'ensemble des jeux

/**
 * Fonction interagissant avec la base de données pour récupérer un jeu ou l'ensemble des jeux.
 * En fonction des paramètres, la fonction retourne un tableau
 *
 * @param $id
 * @return bool|mysqli_result|array
 */
function getJeux($type, $id = null, $user = false): bool|mysqli_result|array
{
    global $conn;

    if ($id == null && !$user) {
        $query = "SELECT * FROM `jeux` WHERE `jeux`.`type` = '$type'";
    } else if ($user) {
        $id = intval($id);
        $query = "SELECT `jeux`.*
                FROM `jeux`
                INNER JOIN `topics` ON `jeux`.`id` = `topics`.`jeux_id`
                WHERE `topics`.`user_id` = '$id' 
                AND `jeux`.`type` = '$type'";
    } else {
        $id = intval($id);
        $query = "SELECT * FROM `jeux` 
                WHERE `jeux`.`id` = '$id'";
    }

    $result = $conn->query($query);

    if (mysqli_num_rows($result) != 0) {
        if ($id != null && $user == null) {
            return mysqli_fetch_assoc($result);
        }
        return $result;
    } else {
        return false;
    }
}

function getUsers($id = null): bool|mysqli_result|array
{
    global $conn;

    if ($id == null) {
        $query = "SELECT * FROM `utilisateurs`";
    } else {
        $id = intval($id);
        $query = "SELECT * FROM `utilisateurs` WHERE  `utilisateurs`.`id` = '$id'";
    }

    $result = $conn->query($query);

    if (mysqli_num_rows($result) != 0) {
        if ($id != null) {
            return mysqli_fetch_assoc($result);
        }
        return $result;
    } else {
        return false;
    }
}

?>