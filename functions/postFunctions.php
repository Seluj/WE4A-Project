<!-- functions/postFunctions.php -->
<!-- Fichier contenant les fonctions relatives aux posts : topics et messages -->


<?php

/**
 * Fonction permettant de vérifier si l'utilisateur veut ajouter un nouveau topic ou un nouveau message
 * @return void Ne retourne rien
 */
function checkEntry(): void
{
    // Si l'utilisateur n'a pas cliqué sur le bouton, on quitte la fonction
    if(!isset($_POST["createNewMessage"]))
        return;

    // Si l'utilisateur a cliqué sur le bouton, on vérifie :
    if ($_POST['createNewMessage'] == "Créer Topic") { // - s'il veut créer un nouveau topic
        checkNewTopic();
    } else if ($_POST['createNewMessage'] == "Envoyer Message") { // - s'il veut créer un nouveau message
        checkNewMessage();
    }
}

/**
 * Fonction permettant de vérifier les données fournies par l'utilisateur lors de la création d'un nouveau message
 * @return void Ne retourne rien
 */
function checkNewMessage(): void
{
    // On récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // récupération des données et sécurisation
    $message = securizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idTopic = $_GET['topic'];

    // Creation de la requête
    $query = "INSERT INTO messages (id, contenu, user_id, topics_id) VALUES (NULL, '$message', '$idAuteur', '$idTopic')";


    // Execution de la requête, verification et redirection
    if ($conn->query($query) === TRUE) {
        header("Location: ./index.php?topic=" . $idTopic);
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}


/**
 * Fonction permettant de vérifier les données fournies par l'utilisateur lors de la création d'un nouveau topic
 * @return void Ne retourne rien
 */
function checkNewTopic(): void
{
    // On récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // récupération des données et sécurisation
    $titre = securizeString_ForSQL($_POST['choix_titre']);
    $message = securizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idJeux = $_GET['jeu'];

    // Création des requêtes :
    
    // - Requête pour créer le topic
    $insert_topic = "INSERT INTO `topics` (`id`, `date_edit`, `titre`, `user_id`, `jeux_id`) 
        VALUES (NULL, current_timestamp(), '$titre', '$idAuteur', '$idJeux')";

    // - Requête pour récupérer l'id du topic créé pour ensuite créer le premier message
    $query_topic = "SELECT `topics`.*
        FROM `topics`
        WHERE `topics`.`jeux_id` = '$idJeux' AND `topics`.`titre` = '$titre' AND `topics`.`user_id` = '$idAuteur';";

    // Execution des requêtes et verification
    $conn->query($insert_topic);

    $result = $conn->query($query_topic);

    // Si la requête a fonctionné, on récupère l'id du topic créé et on crée le message
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $idTopic = $row['id'];
        $insert_message = "INSERT INTO `messages` (`id`, `contenu`, `user_id`, `topics_id`) 
                        VALUES (NULL, '$message', '$idAuteur', '$idTopic')";
        $conn->query($insert_message);
        header("Location: ./index.php?topic=" . $idTopic);
    } else {
        echo "Error: " . $insert_topic . "<br>" . $conn->error;
    }
}

?>