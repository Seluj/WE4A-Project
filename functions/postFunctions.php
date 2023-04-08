<?php

// Fonction permettant de répartir la création d'un nouveau topic ou un nouveau message
function checkEntry() {
    if(!isset($_POST["createNewMessage"]))
        return;
    if ($_POST['createNewMessage'] == "Créer Topic") {
        checkNewTopic();
    } else if ($_POST['createNewMessage'] == "Envoyer Message") {
        checkNewMessage();
    }
}

// Fonction permettant de créer un nouveau message
function checkNewMessage() {
    global $conn;

    // récupération des données et sécurisation
    $message = SecurizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idtopic = $_GET['topic'];

    // Creation de la requete
    $query = "INSERT INTO messages (id, contenu, user_id, topics_id) VALUES (NULL, '$message', '$idAuteur', '$idtopic')";


    // Execution de la requete, verification et redirection
    if ($conn->query($query) === TRUE) {
        header("Location: ./index.php?topic=".$idtopic);
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Fonction permettant de créer un nouveau topic
function checkNewTopic() {
    global $conn;

    // récupération des données et sécurisation
    $titre = SecurizeString_ForSQL($_POST['choix_titre']);
    $message = SecurizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idjeux = $_GET['jeux'];

    // Création des requetes
    $insert_topic = "INSERT INTO `topics` (`id`, `date_edit`, `titre`, `user_id`, `jeux_id`) VALUES (NULL, current_timestamp(), '$titre', '$idAuteur', '$idjeux')";

    $query_topic = "SELECT `topics`.*
            FROM `topics`
            WHERE `topics`.`jeux_id` = '$idjeux' AND `topics`.`titre` = '$titre' AND `topics`.`user_id` = '$idAuteur';";

    // Execution des requetes et verification
    $result = $conn->query($insert_topic);

    $result = $conn->query($query_topic);

    // Si la requete a fonctionné, on récupère l'id du topic créé et on crée le message
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $idtopic = $row['id_post'];
        $insert_message =
            "INSERT INTO `messages` (`id`, `contenu`, `user_id`, `topics_id`) 
            VALUES (NULL, '$message', '$idAuteur', '$idtopic')";
        $result = $conn->query($insert_message);
        header("Location: ./index.php?topic=".$idtopic);
    } else {
        echo "Error: " . $insert_topic . "<br>" . $conn->error;
    }


}

?>