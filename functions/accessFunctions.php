<!-- functions/accessFunctions.php -->
<!-- Fichier contenant les fonctions permettant de récupérer des informations dans la base de données -->


<?php

/**
 * Fonction permettant d'obtenir un ou plusieurs messages d'un topic en fonction des paramètres
 * @param $id int l'id du topic
 * @param $type String le type de requête à effectuer entre "all" ou "first"
 *                      First permet de récupérer le premier message du topic
 *                      All permet de récupérer l'ensemble des messages du topic
 * @return bool|mysqli_result|array Retourne un tableau pour tous les topics, le résultat d'une requête pour un seul topic ou false en cas d'erreur
 */
function getMessages(int $id, String $type): bool|mysqli_result|array
{
    $id = intval($id);
    // On récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // On effectue la requête en fonction du type de requête
    if ($type == "all") { // Si on veut récupérer tous les messages
        $query = "SELECT * FROM `messages` 
                WHERE `messages`.`topics_id` = '$id'";
    } else if ($type == "first") { // Si on veut récupérer le premier message
        $query = "SELECT * FROM `messages` 
                WHERE `messages`.`topics_id` = '$id' 
                ORDER BY `messages`.`id` ASC 
                LIMIT 1";
    } else { // Si le type de requête n'est pas reconnu, on retourne false
        return false;
    }

    // On exécute la requête et on vérifie qu'elle a bien fonctionné
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) { // Si la requête a fonctionné, on retourne le résultat
        if ($type == "first") { // Si on a récupéré un seul message, on retourne un tableau associatif
            return mysqli_fetch_assoc($result);
        } else { // Si on a récupéré plusieurs messages, on retourne le résultat de la requête
            return $result;
        }
    } else { // Si la requête n'a pas fonctionné, on retourne false
        return false;
    }
}

/**
 * Fonction permettant de récupérer un topic ou l'ensemble des topics d'un jeu en fonction des paramètres
 * @param int|null $id L'id du jeu, l'id d'un topic ou null si on veut récupérer l'ensemble les topics
 * @param String $type Le type de requête à effectuer entre "all" ou "one"
 *                    All permet de récupérer l'ensemble des topics d'un jeu
 *                    One permet de récupérer un seul topic
 * @return bool|mysqli_result|array Retourne un tableau pour tous les topics, le résultat d'une requête pour un seul topic ou false en cas d'erreur
 */
function getTopics(int|null $id, String $type): bool|mysqli_result|array
{
    $id = intval($id);

    // On récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // On effectue la requête en fonction du type de requête
    if ($type == "all") { // Si on veut récupérer tous les topics
        if ($id == null) { // Si on veut récupérer tous les topics sans préciser le jeu
            $query = "SELECT `topics`.*
                    FROM `topics`
                    ORDER BY `topics`.`date_edit` DESC";
        } else { // Si on veut récupérer tous les topics d'un jeu
            $query = "SELECT * FROM `topics` 
                    WHERE `topics`.`jeux_id` = '$id' 
                    ORDER BY `topics`.`date_edit` DESC";
        }
    } else if ($type == "one") { // Si on veut récupérer un seul topic
        $query = "SELECT * FROM `topics` 
                WHERE `topics`.`id` = '$id'";
    } else { // Si le type de requête n'est pas reconnu, on retourne false
        return false;
    }

    // On exécute la requête et on vérifie qu'elle a bien fonctionné
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) { // Si la requête a fonctionné
        if ($type == "one") { // Si on a récupéré un seul topic, on retourne un tableau associatif
            return mysqli_fetch_assoc($result);
        } else { // Si on a récupéré plusieurs topics, on retourne le résultat
            return $result;
        }
    } else { // Si la requête n'a pas fonctionné, on retourne false
        return false;
    }
}

/**
 * Fonction permettant de récupérer un jeu, l'ensemble des jeux ou les jeux où l'utilisateur a créé un topic
 * @param int $type Le type de jeu à récupérer (0 pour les jeux de société, 1 pour les jeux vidéos)
 * @param int|null $id L'id d'un joueur, l'id d'un jeu ou null si on veut récupérer l'ensemble des jeux
 * @param bool $user true si on veut récupérer les jeux où l'utilisateur a créé un topic, false sinon
 * @return bool|mysqli_result|array Retourne un tableau pour tous les jeux, le résultat d'une requête pour un seul jeu ou false en cas d'erreur
 */
function getJeux(int $type, int|null $id = null, bool $user = false): bool|mysqli_result|array
{
    // On récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // On effectue la requête en fonction des paramètres
    if ($id == null && !$user) { // Si on veut récupérer tous les jeux
        $query = "SELECT * FROM `jeux` WHERE `jeux`.`type` = '$type'";
    } else if ($user) { // Si on veut récupérer les jeux où l'utilisateur a créé un topic
        // On force la récupération de l'id de l'utilisateur connecté si on ne précise pas d'id
        $query = "SELECT DISTINCT `jeux`.*
                FROM `jeux`
                INNER JOIN `topics` ON `jeux`.`id` = `topics`.`jeux_id`
                WHERE `topics`.`user_id` = '$id' 
                AND `jeux`.`type` = '$type'";
    } else { // Si on veut récupérer un seul jeu
        $id = intval($id);
        $query = "SELECT * FROM `jeux` 
                WHERE `jeux`.`id` = '$id'";
    }

    // On exécute la requête et on vérifie qu'elle a bien fonctionné
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) { // Si la requête a fonctionné
        if ($id != null && $user == null) { // Si on a récupéré un seul jeu, on retourne un tableau associatif
            return mysqli_fetch_assoc($result);
        } else { // Sinon, on retourne le résultat de la requête
            return $result;
        }
    } else { // Si la requête n'a pas fonctionné, on retourne false
        return false;
    }
}

/**
 * Fonction permettant de récupérer un utilisateur ou l'ensemble des utilisateurs de la base de données
 * @param int|null $id L'id d'un utilisateur ou null si on veut récupérer l'ensemble des utilisateurs
 * @return bool|mysqli_result|array Retourne un tableau pour tous les utilisateurs, le résultat d'une requête pour un seul utilisateur ou false en cas d'erreur
 */
function getUsers(int|null $id = null): bool|mysqli_result|array
{
    // On récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // On effectue la requête en fonction des paramètres
    if ($id == null) { // Si on veut récupérer tous les utilisateurs
        $query = "SELECT * FROM `utilisateurs`";
    } else { // Si on veut récupérer un seul utilisateur
        $query = "SELECT * FROM `utilisateurs` WHERE  `utilisateurs`.`id` = '$id'";
    }

    // On exécute la requête et on vérifie qu'elle a bien fonctionné
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) { // Si la requête a fonctionné
        if ($id != null) { // Si on a récupéré un seul utilisateur, on retourne un tableau associatif
            return mysqli_fetch_assoc($result);
        } else { // Sinon, on retourne le résultat de la requête
            return $result;
        }
    } else { // Si la requête n'a pas fonctionné, on retourne false
        return false;
    }
}

?>