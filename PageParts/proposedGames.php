<div id="jeux" class="container">
    <?php if($connecte){ ?>
        <div class="liste_jeux" id="jeux_visites">
            <h1>Jeux visités</h1>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($jeuxVisites)) { ?>
                    <li><a href="./index.php?site=<?php echo $row["type"] ?>&jeu=<?php echo $row['id'] ?>">
                            <?php echo $row["Nom"] ?></a></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <div class="liste_jeux" id="jeux_proposes">
        <h1><?php echo $nomSectionJeux ?></h1>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($jeux)) { ?>
                <li><a href="./index.php?site=<?php echo $row["type"] ?>&jeu=<?php echo $row['id'] ?>">
                    <?php echo $row["Nom"] ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>