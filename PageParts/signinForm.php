
<div id="Ajout" class="fenetre_interaction">

    <form method="post" action="#" id="signin">

        <div>
            <input id="nom" name="nom" type="text" required="required"
                   pattern="[a-zA-Z-'--- -é-è-à-ç]{1,20}"/>
            <label for="nom">Nom</label>
        </div>

        <div>
            <input id="prenom" name="prenom" type="text" required="required"
                   pattern="[a-zA-Z-'---é-è-à-ç]{1,20}"/>
            <div class="cut cut-prenom"></div>
            <label for="prenom" class="placeholder">Prénom</label>
        </div>

        <div>
            <input id="email" name="email" type="email" required="required"/>
            <label for="email">Email</label>
        </div>

        <div>
            <input id="mdp" name="mdp" type="password" required="required"
                   pattern="[a-zA-Z0-9-'--]{8,100}"/>
            <label for="mdp">Mot de passe</label>
        </div>

        <div>
            <input id="pseudo" name="pseudo" type="text" required="required"
                   pattern="[a-zA-Z0-9-'--]{1,20}"/>
            <label for="pseudo">Pseudo</label>
        </div>

        <div>
            <input id="avatar" name="avatar" type="file">
            <label for="avatar">Avatar</label>
        </div>

        <div>
            <input id="affichage_nom" name="affichage_nom" type="checkbox">
            <label for="affichage_nom">Afficher mon nom</label>
        </div>

        <input type="submit" name="inscrire" value="S'inscrire" />
        <button type="button" id="button2"  onClick="myFunction()">Se connecter</button>
    </form>
</div>