<?php

// Fonction permettant de se connecter à la base de données
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

function boucle($text, $number) {
    for($i = 1; $i <= $number; $i++) {
        ?><li> <img src="images/Meeple.png" alt="icone">
        <a href=""><?php echo $text." ".$i ?></a></li><?php
    }
}

// Fonction permettant de répartir la création d'un nouveau topic ou un nouveau message
function checkEntry() {
    if ($_POST['newMessage'] == "Créer Topic") {
        checkNewTopic();
    } else if ($_POST['newMessage'] == "Envoyer Message") {
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
    $insert_topic = "INSERT INTO `topics` (`id_post`, `date_edit`, `titre`, `user_id`, `jeux_id`) VALUES (NULL, current_timestamp(), '$titre', '$idAuteur', '$idjeux')";

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
    if (!isset($_SESSION['id'])) {
        if (isset($_POST['connecter'])) {
            checkConnectionForm();
        } else if (isset($_POST['inscrire'])) {
            checkNewAccountForm();
        }
    } else {
        /*header("Location: ./index.php");*/
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

        //$image = $_POST['avatar'];

        try {

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['avatar']['error']) ||
                is_array($_FILES['avatar']['error'])
            ) {
                ?>
                <script>
                    alert("Invalid parameters.");
                </script>
                <?php
                throw new RuntimeException('Invalid parameters.');
            }

            // Check $_FILES['avatar']['error'] value.
            switch ($_FILES['avatar']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    ?>
                    <script>
                        alert("No file sent.");
                    </script>
                    <?php
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    ?>
                    <script>
                        alert("Exceeded filesize limit.");
                    </script>
                    <?php
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    ?>
                    <script>
                        alert("Unknown errors..");
                    </script>
                    <?php
                    throw new RuntimeException('Unknown errors.');
            }

            // You should also check filesize here.
            if ($_FILES['avatar']['size'] > 10000000) {
                ?>
                <script>
                    alert("Exceeded filesize limit.");
                </script>
                <?php
                throw new RuntimeException('Exceeded filesize limit.');
            }

            // DO NOT TRUST $_FILES['avatar']['mime'] VALUE !!
            // Check MIME Type by yourself.
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
                ?>
                <script>
                    alert("Invalid file format.");
                </script>
                <?php
                throw new RuntimeException('Invalid file format.');
            }
            $imagePath = "data/users/images";
            // You should name it uniquely.
            // DO NOT USE $_FILES['avatar']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
            if (!move_uploaded_file(
                $_FILES['avatar']['tmp_name'],
                sprintf($imagePath.'/%s.%s',
                    $img = sha1_file($_FILES['avatar']['tmp_name']),
                    $ext
                )
            )) {
                ?>
                <script>
                    alert("Failed to upload your image.");
                </script>
                <?php
                throw new RuntimeException('Failed to move uploaded file.');
            }

            echo 'File is uploaded successfully.';
            ?>
            <script>
                alert("Successfully uploaded your image.");
            </script>
            <?php

            $image = sprintf('/%s.%s',
                $img,
                $ext
            );

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



        /*
        if(is_uploaded_file($imagetemp)) {
            if(move_uploaded_file($imagetemp, $imagePath . $imagename)) {
                //echo "Successfully uploaded your image.";
                ?>
                <script>
                    alert("Successfully uploaded your image.");
                </script>
                <?php
            }
            else {
                echo "Failed to move your image.";
                ?>
                <script>
                    alert("Failed to move your image.");
                </script>
                <?php
            }
        } else {
            echo "Failed to upload your image.";
            ?>
            <script>
                alert("Failed to upload your image.");
            </script>
            <?php
        }
*/

    }
}

//Function to clean up an users input for safety reasons
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