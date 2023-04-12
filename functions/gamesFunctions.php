<?php

/**
 * @return void
 */
function checkNewGame(): void
{

    global $imagesGamesPath, $rulesGamesPath;
    if (!isset($_POST['creer_jeu']))
        return;


    global $conn;

    $idUser = $_SESSION["id"];

    // récupération des données et sécurisation
    $nom = securizeString_ForSQL($_POST["nom"]);
    $description = securizeString_ForSQL($_POST["choix_description"]);

    $image = securizeFile_ForSQL($_FILES, "saisie_image_jeu", 'img', $imagesGamesPath, null);

    if (!$image) {
        ?>
        <script>
            alert("Problème avec l'image.");
        </script>
        <?php
        return;
    }

    $regle = securizeFile_ForSQL($_FILES, "saisie_regles_jeu", 'pdf', $rulesGamesPath, "regles_".$nom);

    if (!$regle) {
        ?>
        <script>
            alert("Problème avec les règles.");
        </script>
        <?php
        return;
    }

    $type = securizeString_ForSQL($_POST["type_jeu"]);

    if ($type == "societe") {
        $type = 0;
    } else {
        $type = 1;
    }

    // requête SQL
    $insert = "INSERT INTO `jeux` (`id`, `Nom`, `Description`, `image`, `type`, `regles`, `admin_id`) 
                VALUES (NULL, '$nom', '$description', '$image', '$type', '$regle', '$idUser')";

    $result = $conn->query($insert);

    if ($result) {
        ?>
        <script>
            alert("Le jeu a bien été ajouté.");
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Erreur lors de l'ajout du jeu.");
        </script>
        <?php
    }
}