<?php

// Fonction permettant de répartir la création d'un nouveau topic ou un nouveau message

/**
 * @return void
 */
function checkEntry(): void
{
    if(!isset($_POST["createNewMessage"]))
        return;
    if ($_POST['createNewMessage'] == "Créer Topic") {
        checkNewTopic();
    } else if ($_POST['createNewMessage'] == "Envoyer Message") {
        checkNewMessage();
    }
}

// Fonction permettant de créer un nouveau message

/**
 * @return void
 */
function checkNewMessage(): void
{
    global $conn;

    // récupération des données et sécurisation
    $message = securizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idTopic = $_GET['topic'];

    // Creation de la requete
    $query = "INSERT INTO messages (id, contenu, user_id, topics_id) VALUES (NULL, '$message', '$idAuteur', '$idTopic')";


    // Execution de la requete, verification et redirection
    if ($conn->query($query) === TRUE) {
        header("Location: ./index.php?topic=" . $idTopic);
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Fonction permettant de créer un nouveau topic

/**
 * @return void
 */
function checkNewTopic(): void
{
    global $conn;

    // récupération des données et sécurisation
    $titre = securizeString_ForSQL($_POST['choix_titre']);
    $message = securizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idJeux = $_GET['jeux'];

    // Création des requetes
    $insert_topic = "INSERT INTO `topics` (`id`, `date_edit`, `titre`, `user_id`, `jeux_id`) 
        VALUES (NULL, current_timestamp(), '$titre', '$idAuteur', '$idJeux')";

    $query_topic = "SELECT `topics`.*
        FROM `topics`
        WHERE `topics`.`jeux_id` = '$idJeux' AND `topics`.`titre` = '$titre' AND `topics`.`user_id` = '$idAuteur';";

    // Execution des requetes et verification
    $result = $conn->query($insert_topic);

    $result = $conn->query($query_topic);

    // Si la requete a fonctionné, on récupère l'id du topic créé et on crée le message
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $idTopic = $row['id_post'];
        $insert_message = "INSERT INTO `messages` (`id`, `contenu`, `user_id`, `topics_id`) 
            VALUES (NULL, '$message', '$idAuteur', '$idTopic')";
        $result = $conn->query($insert_message);
        header("Location: ./index.php?topic=" . $idTopic);
    } else {
        echo "Error: " . $insert_topic . "<br>" . $conn->error;
    }
}

?>