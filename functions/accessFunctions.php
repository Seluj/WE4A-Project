<?php

// Fonction permettant de récupérer un message ou l'ensemble des messages d'un topic
function getMessages($id, $type) {
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
function getTopics($id, $type) {
    global $conn;

    if ($type == "all") {
        $query = "SELECT * FROM topics WHERE jeux_id = '$id'";
    } else if ($type == "one") {
        $query = "SELECT * FROM topics WHERE id = '$id'";
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
function getJeux($id, $type) {
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

?>