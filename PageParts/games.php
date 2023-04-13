<div id="jeux" class="container">
    <?php if($connecte){ ?>
        <div class="liste_jeux" id="jeux_visites">
            <h1>Jeux visités</h1>
            <ul>
                <?php boucle("Jeu", 20) ?>
            </ul>
        </div>
    <?php } ?>
    <div class="liste_jeux" id="jeux_proposes">
        <h1><?php echo $nomSectionJeux ?></h1>
        <ul>
            <?php boucle("Jeu", 20) ?>
        </ul>
    </div>
</div>