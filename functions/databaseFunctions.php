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

// Fonction permettant de se déconnecter de la base de données
function disconnectDatabase() {
    global $conn;
    $conn->close();
}

?>