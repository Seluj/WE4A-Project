<?php

// Function to open connection to database
//--------------------------------------------------------------------------------
function ConnectDatabase(){
    // Create connection

    $config = include('./config.php');

    global $conn;

    $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

function boucle($string, $number)
{
    for($i = 1; $i <= $number; $i++) {
        ?><li> <img src="images/Meeple.png" alt="icone">
        <a href=""><?php echo $string." ".$i ?></a></li><?php
    }
}

?>