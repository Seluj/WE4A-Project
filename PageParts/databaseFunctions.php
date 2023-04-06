<?php

// Fichier contenant les fonctions permettant de se connecter à la base de données et de faire des requêtes



// Fonction permettant de se connecter à la base de données
function ConnectDatabase() {

    $config = include('./config.php');

    global $conn;

    $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

function boucle($text, $number) {
    for($i = 1; $i <= $number; $i++) {
        ?><li> <img src="images/Meeple.png" alt="icone">
        <a href=""><?php echo $text." ".$i ?></a></li><?php
    }
}

// Fonction permettant de répartir la création d'un nouveau topic ou un nouveau message
function checkEntry() {
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

// Fonction permettant de répartir la création d'un nouveau compte ou la connexion
function checkAccount() {
    // Si l'utilisateur n'est pas connecté, on vérifie si il a cliqué sur le bouton de connexion ou d'inscription
    if (!isset($_SESSION['id'])) {
        if (isset($_POST['connecter'])) {
            checkConnectionForm();
        } else if (isset($_POST['inscrire'])) {
            checkNewAccountForm();
        }
    }
}

// Fonction permettant de valider le formulaire de connexion
function checkConnectionForm() {
    global $conn;

    // récupération des données et sécurisation
    $email = SecurizeString_ForSQL($_POST["email"]);
    $mdp = md5($_POST["mdp"]);

    // Création de la requete
    $query = "SELECT * FROM utilisateurs WHERE mail = '$email' AND mdp = '$mdp'";

    // Execution de la requete et verification
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
        // Si la requete a fonctionné, on récupère les données de l'utilisateur et on enregistre les données dans les variables de session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['mail'] = $row['mail'];
        $_SESSION['nom'] = $row['nom'];
        $_SESSION['prenom'] = $row['prenom'];
        $_SESSION['pseudo'] = $row['pseudo'];
        $_SESSION['avatar'] = ($row['avatar']);
        $_SESSION['affichage_nom'] = $row['affichage_nom'];
        $_SESSION['administrateur'] = $row['administrateur'];
        header("Location: ./index.php");
    } else {
        // Si la requete n'a pas fonctionné, on affiche un message d'erreur
        ?>
        <script>
            alert("Email ou mot de passe incorrect.");
        </script>
        <?php
    }
}


// Fonction permettant de valider le formulaire d'inscription
function checkNewAccountForm() {
    global $conn;

    // récupération des données et sécurisation
    $nom = SecurizeString_ForSQL($_POST["nom"]);
    $prenom = SecurizeString_ForSQL($_POST["prenom"]);
    $email = $_POST["email"];
    $mdp = md5($_POST["mdp"]);
    $pseudo = SecurizeString_ForSQL($_POST["pseudo"]);

    // Vérification de l'avatar
    try {

        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (!isset($_FILES['avatar']['error']) || is_array($_FILES['avatar']['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }
        // Check $_FILES['avatar']['error'] value.
        switch ($_FILES['avatar']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        // You should also check filesize here.
        if ($_FILES['avatar']['size'] > 10000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // Check MIME Type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES['avatar']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
            throw new RuntimeException('Invalid file format.');
        }
        $imagePath = "data/users/images";
        // You should name it uniquely.
        // DO NOT USE $_FILES['avatar']['name'] WITHOUT ANY VALIDATION !!
        // Obtain safe unique name from its binary data.
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], sprintf($imagePath.'/%s.%s', $img = sha1_file($_FILES['avatar']['tmp_name']), $ext))) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        // echo 'File is uploaded successfully.';

        // On récupère le nom de l'image final pour l'insérer dans la base de données
        $image = sprintf('/%s.%s', $img, $ext);

        // Création des requetes
        $query_email = "SELECT * FROM utilisateurs WHERE mail = '$email'";
        $query_pseudo = "SELECT * FROM utilisateurs WHERE pseudo = '$pseudo'";
        $query_nom_prenom = "SELECT * FROM utilisateurs WHERE nom = '$nom' AND prenom = '$prenom'";

        // Execution des requetes et verification
        $result_email = $conn->query($query_email);
        $result_pseudo = $conn->query($query_pseudo);
        $result_nom_prenom = $conn->query($query_nom_prenom);
        if (mysqli_num_rows($result_email) != 0) {
            ?>
            <script>
                alert("Cet email est déjà utilisé.");
            </script>
            <?php
        } else if (mysqli_num_rows($result_pseudo) != 0) {
            ?>
            <script>
                alert("Ce pseudo est déjà utilisé.");
            </script>
            <?php
        } else if (mysqli_num_rows($result_nom_prenom) != 0) {
            ?>
            <script>
                alert("Ces nom et prénom sont déjà utilisés.");
            </script>
            <?php
        } else {
            // Si aucune erreur n'a été trouvé, on insère les données de l'utilisateur dans la base de données
            $query_insert =
                "INSERT INTO `utilisateurs` (`id`, `mail`, `mdp`, `nom`, `prenom`, `pseudo`, `avatar`, `affichage_nom`, `administrateur`) 
                VALUES (NULL, '$email', '$mdp', '$nom', '$prenom', '$pseudo', '$image', '0', '0')
                ";

            $result = $conn->query($query_insert);

            if ($result) {
                ?>
                <script>
                    alert("Votre compte a bien été créé.\nVous pouvez maintenant vous connecter.");
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert("Une erreur est survenue lors de la création de votre compte.");
                </script>
                <?php
            }
        }
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }
}

// Fonction permettant de récupérer un message ou l'ensemble des messages d'un topic
function getMessage($id, $type) {
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
function getTopic($id, $type) {
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
        $query = "SELECT * FROM jeux";
    } else if ($type == "one") {
        $query = "SELECT * FROM jeux WHERE id = '$id'";
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


// Fonction permettant de transformer les caractères spéciaux en entités HTML et éviter les injections SQL
function SecurizeString_ForSQL($string) {
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

// Fonction permettant de se déconnecter de la base de données
function DisconnectDatabase() {
    global $conn;
    $conn->close();
}

?>