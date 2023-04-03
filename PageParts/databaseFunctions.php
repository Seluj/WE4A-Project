<?php

// Function to open connection to database
//--------------------------------------------------------------------------------
function ConnectDatabase() {
    // Create connection

    $config = include('./config.php');

    global $conn;

    $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

function boucle($string, $number) {
    for($i = 1; $i <= $number; $i++) {
        ?><li> <img src="images/Meeple.png" alt="icone">
        <a href=""><?php echo $string." ".$i ?></a></li><?php
    }
}

function checkEntry() {
    if ($_POST['newMessage'] == "Créer Topic") {
        checkNewTopic();
    } else if ($_POST['newMessage'] == "Envoyer Message") {
        checkNewMessage();
    }
}


function checkNewMessage() {
    global $conn;

    $message = SecurizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idtopic = $_GET['topic'];

    $query = "INSERT INTO messages (id, contenu, user_id, topics_id) VALUES (NULL, '$message', '$idAuteur', '$idtopic')";

    if ($conn->query($query) === TRUE) {
        header("Location: ./index.php?topic=".$idtopic);
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

function checkNewTopic() {
    global $conn;

    $titre = SecurizeString_ForSQL($_POST['choix_titre']);
    $message = SecurizeString_ForSQL($_POST['choix_message']);
    $idAuteur = $_SESSION['id'];
    $idjeux = $_GET['jeux'];

    $insert_topic = "INSERT INTO `topics` (`id_post`, `date_edit`, `titre`, `user_id`, `jeux_id`) VALUES (NULL, current_timestamp(), '$titre', '$idAuteur', '$idjeux')";

    $query_topic = "SELECT `topics`.*
            FROM `topics`
            WHERE `topics`.`jeux_id` = '$idjeux' AND `topics`.`titre` = '$titre' AND `topics`.`user_id` = '$idAuteur';";


    $result = $conn->query($insert_topic);

    $result = $conn->query($query_topic);

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

function checkAccount() {
    if (!isset($_SESSION['id'])) {
        if (isset($_POST['connecter'])) {
            checkConnectionForm();
        } else if (isset($_POST['inscrire'])) {
            checkNewAccountForm();
        }
    } else {
        header("Location: ./index.php");
    }
}

function checkConnectionForm() {
    global $conn;

    $email = SecurizeString_ForSQL($_POST["email"]);
    $mdp = md5($_POST["mdp"]);

    $query = "SELECT * FROM utilisateurs WHERE mail = '$email' AND mdp = '$mdp'";

    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) {
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
        ?>
        <script>
            alert("Email ou mot de passe incorrect.");
        </script>
        <?php
    }
}



function checkNewAccountForm() {
    global $conn;


    //Données reçues via formulaire?
    if (isset($_POST["nom"])) {

        $nom = SecurizeString_ForSQL($_POST["nom"]);
        $prenom = SecurizeString_ForSQL($_POST["prenom"]);
        $email = $_POST["email"];
        $mdp = md5($_POST["mdp"]);
        $pseudo = SecurizeString_ForSQL($_POST["pseudo"]);
        $avatar = $_POST["avatar"];

        $query_email = "SELECT * FROM utilisateurs WHERE mail = '$email'";
        $query_pseudo = "SELECT * FROM utilisateurs WHERE pseudo = '$pseudo'";
        $query_nom_prenom = "SELECT * FROM utilisateurs WHERE nom = '$nom' AND prenom = '$prenom'";


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

            $query_insert =
                "INSERT INTO `utilisateurs` (`id`, `mail`, `mdp`, `nom`, `prenom`, `pseudo`, `avatar`, `affichage_nom`, `administrateur`) 
                VALUES (NULL, '$email', '$mdp', '$nom', '$prenom', '$pseudo', '$avatar', '0', '0')
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
    }
}

//Function to clean up an user input for safety reasons
//--------------------------------------------------------------------------------
function SecurizeString_ForSQL($string) {
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}


// Function to close connection to database
//--------------------------------------------------------------------------------
function DisconnectDatabase() {
    global $conn;
    $conn->close();
}

?>