
<div id="signin" class="container interaction_container">

    <img class="image_commentaire" src="./images/NewPlayer.png" alt="New Player !">

    <h1 class="titre_interaction">Créer un compte</h1>

    <br><p>________________________________________</p><br>

    <form class="formulaire" method="post" action="#" enctype="multipart/form-data">

        <div class="entrees">
            <label for="nom">Nom</label>
            <input id="nom" class="saisie" name="nom" type="text" required="required" pattern="[a-zA-Z-'--- -é-è-à-ç]{1,20}"/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="prenom" class="placeholder">Prénom</label>
            <input id="prenom" class="saisie" name="prenom" type="text" required="required" pattern="[a-zA-Z-'---é-è-à-ç]{1,20}"/>
            <div class="cut cut-prenom"></div>
        </div>
        <br><br>
        <div class="entrees">
            <label for="email">Email</label>
            <input id="email" class="saisie" name="email" type="email" required="required"/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="mdp">Mot de passe</label>
            <input id="mdp" class="saisie" name="mdp" type="password" required="required" pattern="[a-zA-Z0-9-'--]{8,100}"/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="pseudo">Pseudo</label>
            <input id="pseudo" class="saisie" name="pseudo" type="text" required="required" pattern="[a-zA-Z0-9-'--]{1,20}"/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="avatar">Avatar</label>
            <input id="avatar" name="avatar" type="file">
        </div>
        <br><br>
        <div class="entrees">
            <label for="affichage_nom">Afficher mon nom</label>
            <input id="affichage_nom" class="saisie" name="affichage_nom" type="checkbox">
        </div>
        <br><br>
        <input class="Boutons" type="submit" name="inscrire" value="S'inscrire" />
        <button class="Boutons" type="button" id="button2"  onClick="myFunction()">Se connecter</button>
    </form>
</div>