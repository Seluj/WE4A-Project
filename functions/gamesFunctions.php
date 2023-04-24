<?php

/**
 * Fonction permettant de vérifier les données fournies par l'utilisateur lors de la création d'un nouveau jeu
 * @return void Ne retourne rien
 */
function checkNewGame(): void
{

    
    // Si le bouton de création n'a pas été cliqué, on ne fait rien
    if (!isset($_POST['creer_jeu']))
        return;
    
    // Récupération des variables globales
    global $imagesGamesPath, $rulesGamesPath, $conn;

    $idUser = $_SESSION["id"];

    // récupération des données et sécurisation
    $nom = securizeString_ForSQL($_POST["nom"]);
    $description = securizeString_ForSQL($_POST["choix_description"]);
    $type = securizeString_ForSQL($_POST["type_jeu"]);

    // récupération des fichiers et sécurisation
    $image = securizeFile_ForSQL($_FILES, "saisie_image_jeu", 'img', $imagesGamesPath);

    if (!$image) { // Si l'image n'a pas été ajoutée, on arrête la fonction et on affiche un message d'erreur
        ?>
        <script>
            alert("Problème avec l'image.");
        </script>
        <?php
        return;
    }

    // Les règles sont facultatives, notamment pour les jeux vidéos
    if ($_FILES["saisie_regles_jeu"]['error'] == UPLOAD_ERR_NO_FILE || !isset($_POST["saisie_regles_jeu"])) { // Si aucune règle n'a été ajoutée, on met la variable à NULL
        $regle = NULL;
    } else { // Sinon, on ajoute les règles à la base de données et on sauvegarde le fichier
        $regle = securizeFile_ForSQL($_FILES, "saisie_regles_jeu", 'pdf', $rulesGamesPath, "regles_" . $nom);
    }

    if (!$regle) { // Si les règles n'ont pas été ajoutées, on affiche un message d'erreur et on met la variable à -1 pour bien l'identifier dans la base de données
        ?>
        <script>
            alert("Règles non ajoutées.");
        </script>
        <?php
        $regle = '-1';
    }

    // On convertit le type de jeu en un entier pour l'ajouter à la base de données
    if ($type == "societe") { // Si le jeu est un jeu de société, on met la variable à 0.
        $type = 0;
    } else { // Sinon, on met la variable à 1.
        $type = 1;
    }

    // Création de la requête
    $insert = "INSERT INTO `jeux` (`id`, `Nom`, `Description`, `image`, `type`, `regles`, `admin_id`) 
                VALUES (NULL, '$nom', '$description', '$image', '$type', '$regle', '$idUser')";

    // Execution de la requête et verification
    $result = $conn->query($insert);
    if ($result) { // Si la requête a fonctionné, on affiche un message de succès
        ?>
        <script>
            alert("Le jeu a bien été ajouté.");
        </script>
        <?php
    } else { // Sinon, on affiche un message d'erreur
        ?>
        <script>
            alert("Erreur lors de l'ajout du jeu.");
        </script>
        <?php
    }
}