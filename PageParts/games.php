<div id="jeux" class="container">
    <?php if($connecte){ ?>
        <div class="liste_jeux" id="jeux_visites">
            <h1>Liste des jeux visités</h1>
            <ul>
                <?php boucle("Jeu", 20) ?>
            </ul>
        </div>
    <?php } ?>
    <div class="liste_jeux" id="jeux_proposes">
        <h1>Liste des jeux proposés</h1>
        <ul>
            <?php boucle("Jeu", 20) ?>
        </ul>
    </div>
</div>