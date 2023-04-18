<?php

/**
 * @param $id
 * @param $type
 * @return bool|array|null
 */
function getMessages($id, $type): bool|array|null
{
    global $conn;

    if ($type == "all") {
        $query = "SELECT * FROM messages WHERE topics_id = '$id'";
    } else if ($type == "one") {
        $query = "SELECT * FROM messages WHERE id = '$id'";
    } else {
        return false;
    }
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

// Fonction permettant de récupérer un topic ou l'ensemble des topics d'un jeu

/**
 * @param $id
 * @param $type
 * @return bool|array|null
 */
function getTopics($id, $type): bool|array|null
{
    global $conn;

    if ($type == "all") {
        if ($id == null) {
            $query = "SELECT `topics`.*
                    FROM `topics`
                    ORDER BY `topics`.`date_edit` DESC";
        } else {
            $query = "SELECT * FROM topics WHERE jeux_id = '$id' ORDER BY `topics`.`date_edit` DESC";
        }
    } else if ($type == "one") {
        $query = "SELECT * FROM messages WHERE topics_id = '$id' ORDER BY `messages`.`date_ajout` ASC";
    } else {
        return false;
    }
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

// Fonction permettant de récupérer un jeu ou l'ensemble des jeux

/**
 * @param $id
 * @param $type
 * @return bool|array|null
 */
function getJeux($id, $type): bool|array|null
{
    global $conn;

    if ($type == "all") {
        $query = "SELECT * FROM `jeux`";
    } else if ($type == "one") {
        $query = "SELECT * FROM `jeux` WHERE id = '$id'";
    } else {
        return false;
    }
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        return mysqli_fetch_assoc($result);
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