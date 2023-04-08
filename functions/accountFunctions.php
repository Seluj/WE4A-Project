<?php

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

?>