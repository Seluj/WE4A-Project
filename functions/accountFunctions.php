<!-- functions/accountFunctions.php -->
<!-- Fichier contenant les fonctions relatives aux comptes utilisateurs -->


<?php

/**
 * Fonction permettant de vérifier si un utilisateur est connecté, s'il veut se connecter ou s'enregistrer
 * @return void Ne retourne rien
 */
function checkAccount(string $id): void
{
    // Si l'utilisateur n'est pas connecté, on vérifie :
    if (!isset($_SESSION['id'])) {
        if (isset($_POST['connecter'])) { // - s'il a cliqué sur le bouton de connexion
            // Dans ce cas, on vérifie les identifiants fournis avec la fonction checkConnectionForm
            checkConnectionForm();
        } else if (isset($_POST['inscrire'])) { // - s'il a cliqué sur le bouton d'inscription
            // Dans ce cas, on vérifie les données fournies avec la fonction checkNewAccountForm
            checkNewAccountForm();
        }
    } else if (isset($_POST["modifier_profil"])) {
        updateAccount();
        if ($_POST["ancien_mdp"] != "") {
            updatePassword();
        }
    } else if (isset($_POST["mettre_administrateur"])) {
        updateAdmin($id);
    }

}

// Fonction permettant de valider le formulaire de connexion

/**
 * Fonction permettant de vérifier les identifiants fournis par l'utilisateur lors de la connexion
 * @return void Ne retourne rien
 */
function checkConnectionForm(): void
{
    // On récupère la variable globale $conn pour exécuter la requête
    global $conn;

    // récupération des données et sécurisation
    $email = securizeString_ForSQL($_POST["emailLogin"]);
    $mdp = md5($_POST["mdp"]);

    // Création de la requête
    $query = "SELECT * FROM utilisateurs WHERE mail = '$email' AND mdp = '$mdp'";

    // Execution de la requête et verification
    $result = $conn->query($query);
    if (mysqli_num_rows($result) != 0) { // Si la requête a fonctionné
        // On récupère les données de l'utilisateur et on enregistre les données dans les variables de session
        updateSessionVariables($result);
    } else { // Si la requête n'a pas fonctionné, on affiche un message d'erreur
        ?>
        <script>
            alert("Email ou mot de passe incorrect.");
        </script>
        <?php
    }
}

// Fonction permettant de valider le formulaire d'inscription

/**
 * Fonction permettant de vérifier les données fournies par l'utilisateur lors de l'inscription
 * @return void Ne retourne rien
 */
function checkNewAccountForm(): void
{
    // On récupère les deux mots de passe pour les comparer
    $mdp1 = $_POST["mdp1"];
    $mdp2 = $_POST["mdp2"];

    // Si les deux mots de passe ne correspondent pas, on affiche un message d'erreur et on quitte la fonction
    if ($mdp1 != $mdp2) {
        ?>
        <script>
            alert("Les mots de passe ne correspondent pas.");
        </script>
        <?php
        return;
    }

    // On crypte le mot de passe
    $mdp = md5($mdp1);

    // On récupère la variable globale $conn pour exécuter les requêtes et la variable $imagePath pour récupérer le chemin de sauvegarde des images
    global $conn, $imagePath;

    // récupération des données et sécurisation
    $nom = securizeString_ForSQL($_POST["nom"]);
    $prenom = securizeString_ForSQL($_POST["prenom"]);
    $email = securizeString_ForSQL($_POST["email"]);
    $pseudo = securizeString_ForSQL($_POST["pseudo"]);
    $presentation = securizeString_ForSQL($_POST["presentation"]);

    // Création des requêtes
    $queryEmail = "SELECT * FROM utilisateurs WHERE mail = '$email'";
    $queryPseudo = "SELECT * FROM utilisateurs WHERE pseudo = '$pseudo'";
    $queryNomPrenom = "SELECT * FROM utilisateurs WHERE nom = '$nom' AND prenom = '$prenom'";

    /**
     * Execution des requêtes de verification
     * - Vérification de l'adresse mail
     * - Vérification du pseudo
     * - Vérification du nom et du prénom
     * Dans chacun des cas, si la requête a fonctionné, on affiche un message d'erreur pour éviter les doublons
     * Si aucune erreur n'a été trouvé, on continue le traitement. C'est-à-dire que l'on vérifie l'image et on la sauvegarde, et on insère les données dans la base de données
     */
    $resultEmail = $conn->query($queryEmail);
    $resultPseudo = $conn->query($queryPseudo);
    $resultNomPrenom = $conn->query($queryNomPrenom);
    if (mysqli_num_rows($resultEmail) != 0) {
        ?>
        <script>
            alert("Cet email est déjà utilisé.");
        </script>
        <?php
    } else if (mysqli_num_rows($resultPseudo) != 0) {
        ?>
        <script>
            alert("Ce pseudo est déjà utilisé.");
        </script>
        <?php
    } else if (mysqli_num_rows($resultNomPrenom) != 0) {
        ?>
        <script>
            alert("Ces nom et prénom sont déjà utilisés.");
        </script>
        <?php
    } else {

        // On récupère le nom de l'image finale en vérifiant ses données pour l'insérer dans la base de données
        $image = securizeFile_ForSQL($_FILES, "avatar", 'img', $imagePath);

        if (!$image) { // Si l'image n'a pas été sauvegardée, on affiche un message d'erreur et on quitte la fonction
            ?>
            <script>
                alert("Problème avec l'image.");
            </script>
            <?php
            return;
        }

        // Si aucune erreur n'a été trouvé, on insère les données de l'utilisateur dans la base de données
        $query_insert = "INSERT INTO `utilisateurs` (`id`, `mail`, `mdp`, `nom`, `prenom`, `pseudo`, `presentation`, `avatar`, `affichage_nom`, `administrateur`) 
                VALUES (NULL, '$email', '$mdp', '$nom', '$prenom', '$pseudo', '$presentation', '$image', '0', '0')";

        executeQuery($query_insert);
    }
}

/**
 * Fonction permettant de vérifier les données fournies par l'utilisateur lors de la modification de son compte
 * @return void Ne retourne rien
 */
function updateAccount(): void
{
    // On récupère la variable globale $conn pour exécuter les requêtes et la variable $imagePath pour récupérer le chemin de sauvegarde des images
    global $conn, $imagePath;

    // récupération des données et sécurisation
    $nom = securizeString_ForSQL($_POST["nom"]);
    $prenom = securizeString_ForSQL($_POST["prenom"]);
    $email = securizeString_ForSQL($_POST["email"]);
    $pseudo = securizeString_ForSQL($_POST["pseudo"]);
    $presentation = securizeString_ForSQL($_POST["presentation"]);
    $id = $_SESSION['id'];

    // Création des requêtes
    $queryEmail = "SELECT * FROM utilisateurs WHERE mail = '$email' AND NOT `utilisateurs`.`id` = $id";
    $queryPseudo = "SELECT * FROM utilisateurs WHERE pseudo = '$pseudo' AND NOT `utilisateurs`.`id` = $id";
    $queryNomPrenom = "SELECT * FROM utilisateurs WHERE nom = '$nom' AND prenom = '$prenom' AND NOT `utilisateurs`.`id` = $id";

    /**
     * Execution des requêtes de verification
     * - Vérification de l'adresse mail
     * - Vérification du pseudo
     * - Vérification du nom et du prénom
     * Dans chacun des cas, si la requête a fonctionné, on affiche un message d'erreur pour éviter les doublons
     * Si aucune erreur n'a été trouvé, on continue le traitement. C'est-à-dire que l'on vérifie l'image et on la sauvegarde, et on insère les données dans la base de données
     */
    $resultEmail = $conn->query($queryEmail);
    $resultPseudo = $conn->query($queryPseudo);
    $resultNomPrenom = $conn->query($queryNomPrenom);
    if (mysqli_num_rows($resultEmail) != 0) {
        ?>
        <script>
            alert("Cet email est déjà utilisé.");
        </script>
        <?php
    } else if (mysqli_num_rows($resultPseudo) != 0) {
        ?>
        <script>
            alert("Ce pseudo est déjà utilisé.");
        </script>
        <?php
    } else if (mysqli_num_rows($resultNomPrenom) != 0) {
        ?>
        <script>
            alert("Ces nom et prénom sont déjà utilisés.");
        </script>
        <?php
    } else {

        // On récupère le nom de l'image finale en vérifiant ses données pour l'insérer dans la base de données
        $image = securizeFile_ForSQL($_FILES, "avatar", 'img', $imagePath);

        if (!$image) { // Si l'image n'a pas été sauvegardée, on affiche un message d'erreur et on quitte la fonction
            ?>
            <script>
                alert("Problème avec l'image.");
            </script>
            <?php
            return;
        }

        // Si aucune erreur n'a été trouvé, on modifie les données de l'utilisateur dans la base de données
        $update = "UPDATE `utilisateurs` SET `mail` = '$email', `nom` = '$nom', `prenom` = '$prenom', `pseudo` = '$pseudo', `presentation` = '$presentation', `avatar` = '$image'
                      WHERE `utilisateurs`.`id` = $id";

        executeQuery($update);

        $query = "SELECT * FROM utilisateurs WHERE mail = '$email'";
        $result = $conn->query($query);

        updateSessionVariables($result);
    }

}

/**
 * Fonction permettant de mettre à jour les variables de session
 * @param mysqli_result $result Résultat de la requête
 * @return void Ne retourne rien
 */
function updateSessionVariables(mysqli_result $result): void
{
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $row['id'];
    $_SESSION['mail'] = $row['mail'];
    $_SESSION['nom'] = $row['nom'];
    $_SESSION['prenom'] = $row['prenom'];
    $_SESSION['pseudo'] = $row['pseudo'];
    $_SESSION['presentation'] = $row['presentation'];
    $_SESSION['avatar'] = $row['avatar'];
    $_SESSION['affichage_nom'] = $row['affichage_nom'];
    $_SESSION['administrateur'] = $row['administrateur'];
    header("Location: ./index.php");
}

/**
 * Fonction permettant d'exécuter une requête et d'afficher un message de succès ou d'erreur
 * @param String $query Requête à exécuter
 * @return mysqli_result|bool Résultat de la requête
 */
function executeQuery(string $query): mysqli_result|bool
{

    global $conn;

    // Execution des requêtes et verification
    $result = $conn->query($query);
    if ($result) { // Si la requête a fonctionné, on affiche un message de succès
        ?>
        <script>
            alert("Votre compte a bien été modifié.");
        </script>
        <?php
    } else { // Si la requête n'a pas fonctionné, on affiche un message d'erreur
        ?>
        <script>
            alert("Une erreur est survenue lors de la modification de votre compte.");
        </script>
        <?php
    }
    return $result;
}

/**
 * Fonction permettant de vérifier les données fournies par l'utilisateur lors de la modification de son mot de passe
 * @return void Ne retourne rien
 */
function updatePassword(): void
{
    global $conn;

    // On récupère les deux mots de passe pour les comparer
    $mdp1 = $_POST["mdp1"];
    $mdp2 = $_POST["mdp2"];
    $email = $_POST["email"];
    $ancien_mdp = md5($_POST["ancien_mdp"]);

    $query = "SELECT * FROM utilisateurs WHERE mail = '$email' AND mdp = '$ancien_mdp'";
    // Execution de la requête et verification
    $result = $conn->query($query);

    if (mysqli_num_rows($result) == 0) {
        ?>
        <script>
            alert("Mauvais mot de passe.");
        </script>
        <?php
    }else{
        if ($mdp1 != $mdp2) { // Si les deux mots de passe ne correspondent pas, on affiche un message d'erreur et on quitte la fonction
            ?>
            <script>
                alert("Les mots de passe ne correspondent pas.");
            </script>
            <?php
            return;
        }

        // On sécurise le mot de passe
        $mdp = md5($mdp1);

        $id = $_SESSION['id'];

        // Création des requêtes
        $update = "UPDATE `utilisateurs` SET `mdp` = '$mdp' WHERE `utilisateurs`.`id` = $id";

        // Execution des requêtes et verification
        $result = $conn->query($update);
        if ($result) { // Si la requête a fonctionné, on affiche un message de succès
            ?>
            <script>
                alert("Votre mot de passe a bien été modifié.");
            </script>
            <?php
        } else { // Si la requête n'a pas fonctionné, on affiche un message d'erreur
            ?>
            <script>
                alert("Une erreur est survenue lors de la modification de votre mot de passe.");
            </script>
            <?php
        }
    }
}

/**
 * Fonction permettant de modifier le champ administrateur de la base de données
 * @param string $id ID de l'utilisateur à modifier
 * @return void Ne retourne rien
 */
function updateAdmin(string $id): void
{
    global $conn;

    if (isset($_POST["administrateur"]))
        $administrateur = 1;
    else
        $administrateur = 0;

    $query_insert = "UPDATE `utilisateurs` SET `administrateur` = '$administrateur' WHERE `utilisateurs`.`id` = $id";

    // Execution de la requête et verification
    $result = $conn->query($query_insert);

    if ($result) { // Si la requête a fonctionné, on affiche un message de succès et on redirige l'utilisateur vers la page de connexion
        ?>
        <script>
            alert("L'utilisateur est bien passé administrateur.");
        </script>
        <?php
    } else { // Si la requête n'a pas fonctionné, on affiche un message d'erreur
        ?>
        <script>
            alert("Une erreur est survenue lors de la tentative de modification du statut de cet utilisateur.");
        </script>
        <?php
    }
}
?>