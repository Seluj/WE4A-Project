<form method="post" action="#" id="login">

    <div>
        <input id="email" name="email" type="email" required="required"/>
        <label for="email">Email</label>
    </div>

    <div>
        <input id="mdp" name="mdp" type="password" required="required"
               pattern="[a-zA-Z0-9-'--]{8,100}"/>
        <label for="mdp">Mot de passe</label>
    </div>

    <input type="submit" name="connecter" value="Se connecter" />
    <button type="button" id="button1" onClick="myFunction()">S'inscrire</button>
</form>