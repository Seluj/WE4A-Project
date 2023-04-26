<div id="login" class="container central">

    <img class="image_commentaire" src="<?php echo $littleImagePathLink . "You_re_back.png" ?>" alt="You're Back !">

    <h1 class="titre_interaction">Connexion</h1>


    <form class="container_list" method="post" action="#">

        <div class="entrees">
            <label for="emailLogin">Email :</label>
            <input id="emailLogin" class="saisie" name="emailLogin" type="email" required="required"/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="mdp">Mot de passe :</label>
            <input id="mdp" class="saisie" name="mdp" type="password" required="required" pattern="[a-zA-Z0-9-'--]{8,100}"/>
        </div>
        <br>
        <input class="Boutons" type="submit" name="connecter" value="Se connecter" />
        <button class="Boutons" type="button" id="bouton_inscription" onClick="FunctionInscription()">S'inscrire</button>

        <!-- <button class="Boutons" type="button" id="button1" onClick="myFunction()">S'inscrire</button> -->
    </form>

    <div id="Revenir_accueil" class="linkBox">
        <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
    </div>
</div>