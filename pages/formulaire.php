
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">



    <title>Document</title>
</head>
<body>

<main class="main-container">
    <div class="contain">
        <div class="titre">
            <h1>LOGIN</h1>
        </div>
        <?php if(isset($_GET['erreur'])){?>
            <h3>>> ERREUR DE CONNEXION <<</h3>
        <?php }?>
        <form action="../inc/trait_form.php" method="post">
        <p><input type="email" name="email" placeholder="Adresse email"/></p>
        <p><input type="password" name="mdp" placeholder="Mot de Passe"/></p>
            <input type="submit" value="Valider"/>
            <div class="sign">
                <button><a href="../pages/inscription.php">S'inscrire</a></button>
            </div>
        </form>
    </div>
        </main>

</body>
</html>
