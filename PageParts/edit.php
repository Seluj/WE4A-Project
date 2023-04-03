<?php
$nom = "Jean";
$prenom = "Menton";
$email = "arrobase@arobase.fr";
$pseudo = "TheBest";
$avatar = "images/Avatar.jpg";
$affiche_nom = 1;
?>
<div id="edit_profile" class="container interaction_container">

    <img class="image_commentaire" src="./images/NewPlayer.png" alt="New Player !">

    <h1 class="titre_interaction">Modifier Profil</h1>

    <br><p>________________________________________</p><br>

    <form class="formulaire" method="post" action="#" enctype="multipart/form-data">

        <div class="entrees">
            <label for="nom">Nom</label>
            <input id="nom" class="saisie" name="nom" type="text" required="required"
                   pattern="[a-zA-Z-'--- -é-è-à-ç]{1,20}" placeholder=<?php echo $nom ?>/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="prenom" class="placeholder">Prénom</label>
            <input id="prenom" class="saisie" name="prenom" type="text" required="required"
                   pattern="[a-zA-Z-'---é-è-à-ç]{1,20}" placeholder=<?php echo $prenom ?>/>
            <div class="cut cut-prenom"></div>
        </div>
        <br><br>
        <div class="entrees">
            <label for="email">Email</label>
            <input id="email" class="saisie" name="email" type="email" required="required" placeholder=<?php echo $email ?>/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="pseudo">Pseudo</label>
            <input id="pseudo" class="saisie" name="pseudo" type="text" required="required"
                   pattern="[a-zA-Z0-9-'--]{1,20}" placeholder=<?php echo $pseudo ?>/>
        </div>
        <br><br>
        <div class="entrees">
            <label for="avatar">Avatar</label>
            <input id="avatar" name="avatar" type="file" value=<?php echo $avatar ?>>
        </div>
        <br><br>
        <div class="entrees">
            <label for="affichage_nom">Afficher mon nom</label>
            <input id="affichage_nom" class="saisie" name="affichage_nom" type="checkbox"
                <?php if($affiche_nom != 0){echo "checked";} ?>>
        </div>
        <br><br>
        <input class="Boutons" type="submit" name="inscrire" value="S'inscrire" />
        <button class="Boutons" type="button" id="button2"  onClick="myFunction()">Se connecter</button>
    </form>
</div>