<!-- PageParts/signinForm.php -->
<!-- Fichier contenant le formulaire d'inscription et de modification du profil -->
<!-- Pour la modification, on préremplit chaque champ avec les valeurs correspondantes -->

<?php $image_deco = "";

// On choisi l'image en fonction des circonstances (utilisateur connecté : modification)
if ($connecte) {
    $image_deco = $littleImagePathLink . "Some_Changes.png";
} else {
    $image_deco = $littleImagePathLink . "New_Player.png";
} ?>

<div id="signin" class="container central deroulant">

    <!-- Image au coin gauche de la partie centrale -->
    <img class="image_commentaire" src="<?php echo $image_deco; ?>" alt="New Player !">

    <h1 class="titre_interaction"><?php if (!$connecte) { ?>Créer un compte<?php } else { ?>Modifier Profil<?php } ?></h1>

    <!-- Formulaire -->
    <form class="container_list" method="post" action="#" enctype="multipart/form-data">

        <div class="entrees">
            <label for="nom">Nom :</label>
            <input id="nom" class="saisie" name="nom" type="text" required="required" pattern="[a-zA-Z-'--- -é-è-à-ç]{1,20}" value="<?php echo $nom; ?>"/>
        </div>

        <br><br>
        <div class="entrees">
            <label for="prenom" class="placeholder">Prénom :</label>
            <input id="prenom" class="saisie" name="prenom" type="text" required="required" pattern="[a-zA-Z-'---é-è-à-ç]{1,20}" value="<?php echo $prenom; ?>" />
            <div class="cut cut-prenom"></div>
        </div>

        <br><br>
        <div class="entrees">
            <label for="email">Email :</label>
            <input id="email" class="saisie" name="email" type="email" required="required" value="<?php echo $email; ?>"/>
        </div>

        <br><br>
        <div class="entrees">
            <label for="pseudo">Pseudo :</label>
            <input id="pseudo" class="saisie" name="pseudo" type="text" required="required" pattern="[a-zA-Z0-9-'--]{1,20}" value="<?php echo $pseudo; ?>"/>
        </div>

        <br><br>
        <div class="entrees">
            <label for="presentation">Présentation :</label><br>
            <textarea class="zone_texte" id="presentation" name="presentation" placeholder="Presentation"><?php echo $presentation; ?></textarea>
        </div>

        <br><br>
        <div class="entrees">
            <?php // Si l'utilisateur est connecté, on affiche son avatar actuel
            if ($connecte) { ?><img id="mini_avatar" class="avatar" src="<?php echo $avatar; ?>" alt=""><?php } ?>
            <label for="avatar">Avatar :</label>

            <!-- Script pour afficher une alerte lorsque l'utilisateur a téléchargé un fichier -->
            <script>
                function addFile() {
                    const fileInput = document.getElementById('avatar');
                    if (fileInput.files.length > 0) {
                        alert("Le fichier a été téléchargé !");
                    }
                }
            </script>
            <input id="avatar" class="<?php echo $class; ?>" name="avatar" type="file" onchange="addFile()">
        </div>

        <br><br>
        <div class="entrees" id="div_affiche_nom">
            <label for="affichage_nom">Afficher mon nom</label>
            <input id="affichage_nom" class="input_center" name="affichage_nom" type="checkbox" <?php if ($affichage_nom) {echo "checked";} ?>>
        </div>

        <?php // On affiche l'input de l'ancien mot de passe seulement si l'utilisateur est connecté (modification de profil)
        $required = 'required="required"'; // Variable permettant de rendre obligatoire ou non la saisie des mots de passe
        if ($connecte) {                   // Par exemple, si l'utilisateur souhaite modifier son profil mais pas son mdp
            $required = "";
            ?>
            <br><br>
            <div class="entrees">
                <label for="ancien_mdp">Ancien mot de passe :</label>
                <input id="ancien_mdp" class="saisie" name="ancien_mdp" type="password" pattern="[a-zA-Z0-9-'--]{8,100}"/>
            </div>
        <?php } ?>

            <br><br>
            <div class="entrees">
                <label for="mdp1">Mot de passe :</label>
                <input id="mdp1" class="saisie" name="mdp1" type="password" <?php echo $required; ?> pattern="[a-zA-Z0-9-'--]{8,100}"/>
            </div>

            <br><br>
            <div class="entrees">
                <label for="mdp2">Confirmation :</label>
                <input id="mdp2" class="saisie" name="mdp2" type="password" <?php echo $required; ?> pattern="[a-zA-Z0-9-'--]{8,100}"/>
            </div>

        <br><br>

        <!-- Si l'utilisateur est connecté alors, il veut modifier son profil donc on affiche les boutons en conséquence -->
        <?php if (!$connecte) { ?>
            <button class="Boutons" type="button" id="button2"  onClick="FunctionReturnConnect()">Retour</button>
            <input class="Boutons" type="submit" name="inscrire" value="S'inscrire" />
        <?php } else {?>
            <input class="Boutons" type="submit" name="modifier_profil" value="Modifier Profil" />
        <?php } ?>
    </form><br><br>

    <div class="Boutons Revenir_accueil">
        <a href="./index.php" class="backlink police"><< Revenir à l'accueil</a>
    </div>
</div>