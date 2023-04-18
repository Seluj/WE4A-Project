<?php

function searchInGame($idJeu, $search) {
    if (!is_int($idJeu)) {
        return false;
    }

    global $conn;

    $query = "SELECT `messages`.*, `topics`.*
        FROM `messages` 
	    LEFT JOIN `topics` ON `messages`.`topics_id` = `topics`.`id`
        WHERE `messages`.`contenu` LIKE '%$search%'`topics`.`titre` LIKE '%$search%' AND `jeux`.`id` = '$idJeu'";
}

function searchInTopic($idTopic, $search) {
    if (!is_int($idTopic)) {
        return false;
    }
}

function searchInAll($search) {

}