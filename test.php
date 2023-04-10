<?php
include('./functions/databaseFunctions.php');
connectDatabase();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Test</title>
    </head>
    <body>
        <p>Test</p>
        <?php

        $query =
            "SELECT * FROM `utilisateurs`";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) != 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo '<li>Découvrir <a href="./showBlog.php?userID=' . $row["id"] . '">le blog de ' . $row["pseudo"] . '</a></li>';
            }
            echo "</ul>";
        } else {
            echo '<p class="warning"> Aucun utilisateur/blog n\'existe dans le système pour l\'instant!</p>';
        }


        ?>
    </body>
</html>

