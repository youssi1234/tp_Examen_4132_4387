<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>S'inscrire</title> </head>
<body>
<div class="main-container">

    <div class="contain">
        <div class="titre">
            <h1>SIGN IN</h1>
        </div>

        <?php if (isset($_GET['erreur'])) { ?>
            <div class="erreur"> <h3><< Email déjà utilisé >></h3>
            </div>
        <?php } ?>

        <form action="../inc/trait_inscrip.php" method="post">
            <p><input type="text" name="nom" placeholder="Nom Utilisateur"/></p>
            <p><input type="email" name="email" placeholder="Adresse email"/></p>
            <p><input type="password" name="mdp" placeholder="Mot de Passe"/></p>
            <p><input type="date" name="ddns" placeholder="Date de naissance"/></p>
            <p><input type="text" name="ville" placeholder="Ville d'origine"/></p>
            <p><input type="text" name="genre" placeholder="Votre genre"/></p>

            <input type="submit" value="Valider"/>
            <div class="sign">
                <button class="action-button"><a href="../pages/formulaire.php">Login</a></button> </div>
        </form>
    </div>

</div>
</body>
</html>