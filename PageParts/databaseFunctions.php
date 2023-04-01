<?php





// Function to open connection to database
//--------------------------------------------------------------------------------
function ConnectDatabase(){
    // Create connection

    $config = include('./config.php');

    echo $config['host'];

    global $conn;

    $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo $config['host'];
}