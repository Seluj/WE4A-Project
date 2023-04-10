<?php

// Fichier contenant les fonctions permettant de se connecter à la base de données et de faire des requêtes



// Fonction permettant de se connecter à la base de données
function connectDatabase() {

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

// Fonction permettant de transformer les caractères spéciaux en entités HTML et éviter les injections SQL
function securizeString_ForSQL($string) {
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}


function securizeFile_ForSQL($file, $name, $type, $savePath) {

    $image = false;

    // Vérification de l'avatar
    try {


        if ($type == 'img') {
            $array = array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            );
        } else if ($type == 'video') {
            $array = array(
                'mp4' => 'video/mp4',
                'avi' => 'video/avi',
                'mov' => 'video/mov',
            );
        } else if ($type == 'audio') {
            $array = array(
                'mp3' => 'audio/mp3',
                'wav' => 'audio/wav',
                'ogg' => 'audio/ogg',
            );
        } else if ($type == "pdf") {
            $array = array(
                'pdf' => 'application/pdf',
            );
        } else {
            throw new RuntimeException('Invalid file type.');
        }


        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (!isset($file[$name]['error']) || is_array($file[$name]['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }
        // Check $_FILES[$name]['error'] value.
        switch ($file[$name]['error']) {
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
        if ($file[$name]['size'] > 10000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // Check MIME Type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search($finfo->file($file[$name]['tmp_name']), $array, true)) {
            throw new RuntimeException('Invalid file format.');
        }
        $imagePath = "data/users/images";
        // You should name it uniquely.
        // DO NOT USE $_FILES[$name]['name'] WITHOUT ANY VALIDATION !!
        // Obtain safe unique name from its binary data.
        if (!move_uploaded_file($file[$name]['tmp_name'], sprintf($savePath.'/%s.%s', $img = sha1_file($file[$name]['tmp_name']), $ext))) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        $image = sprintf('/%s.%s', $img, $ext);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }
    // echo 'File is uploaded successfully.';
    return $image;
}


function checkSite($name) {
    if (!isset($_GET['site'])) {
        header("Location: ./$name?site=0");
        return false;
    }

    $site = $_GET['site'];
    if ($site != 0 && $site != 1) {
        header("Location: ./$name?site=0");
        return false;
    }
    return $site;
}


// Fonction permettant de se déconnecter de la base de données
function disconnectDatabase() {
    global $conn;
    $conn->close();
}

?>