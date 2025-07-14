<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Bienvenue'; ?></title>

    <link href="../assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/css/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="main-container">
        <div class="contain"> 
            <div class="contener"> 
                <div class="titre">
                    <p>Bienvenue sur</p>
                    <h1>Nom de votre application</h1>
                </div>
                <div class="button-group">
                    <div>
                        <button class="action-button"><a href="../pages/inscription.php">S'inscrire</a></button>
                    </div>
                    <div>
                        <button class="action-button"><a href="../pages/formulaire.php">Se connecter</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>