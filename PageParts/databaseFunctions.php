<?php

// Function to open connection to database
//--------------------------------------------------------------------------------
function ConnectDatabase(): void
{
    // Create connection

    $config = include('./config.php');

    global $conn;

    $conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

function boucle($string, $number): void
{
    for($i = 1; $i <= $number; $i++) {
        ?><li> <img src="images/Meeple.png" alt="icone">
        <a href=""><?php echo $string." ".$i ?></a></li><?php
    }
}


function CheckNewAccountForm(){
    global $conn;

    $creationAttempted = false;
    $creationSuccessful = false;
    $error = NULL;

    //Données reçues via formulaire?
    if(isset($_POST["nom"])){

        $nom = SecurizeString_ForSQL($_POST["nom"]);
        $prenom = SecurizeString_ForSQL($_POST["prenom"]);
        $email = $_POST["email"];
        $mdp = md5($_POST["mdp"]);
        $pseudo = SecurizeString_ForSQL($_POST["pseudo"]);
        $avatar = $_POST["avatar"];

        $query_check = "SELECT * FROM utilisateurs WHERE mail = '$email'";

        $result = $conn->query($query_check);
        if (mysqli_num_rows($result) != 0) {
            ?>
            <script>
                function myFunction() {
                    alert("I am an alert box!");
                }
                myFunction();
            </script>
            <?php
            header("Location: ../newAccount.php");
        } else {

            $query_insert =
                "INSERT INTO `utilisateurs` (`id`, `mail`, `mdp`, `nom`, `prenom`, `pseudo`, `avatar`, `affichage_nom`, `administrateur`) 
                VALUES (NULL, '$email', '$mdp', '$nom', '$prenom', '$pseudo', '$avatar', '0', '0')
                ";

            $result = $conn->query($query_insert);
        }

    }

    $resultArray = ['Attempted' => $creationAttempted,
        'Successful' => $creationSuccessful,
        'ErrorMessage' => $error];

    return $resultArray;
}

//Function to clean up an user input for safety reasons
//--------------------------------------------------------------------------------
function SecurizeString_ForSQL($string): string
{
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}


// Function to close connection to database
//--------------------------------------------------------------------------------
function DisconnectDatabase(): void
{
    global $conn;
    $conn->close();
}

?>