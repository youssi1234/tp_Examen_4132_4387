<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Titre par défaut'; ?></title>

    <link href="../assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/css/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header class="py-3 container-fluid">
        <div class="row align-items-center">
            <div class="col-3">
                <a class="navbar-brand" href="../index.php">
                    <img src="../assets/image/logo.svg" alt="Nom du Logo" class="header-logo"> </a>
            </div>
            
            <nav class="col-9">
                <ul class="nav nav-pills justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>"
                            href="../index.php">
                            <i class="bi bi-house me-2"></i> Déconnexion
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'filtre.php') ? 'active' : '' ?>"
                            href="../pages/filtre.php">
                            <i class="bi bi-filter me-2"></i>
                            Filtre
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'liste.php') ? 'active' : '' ?>"
                            href="../pages/liste.php">
                            <i class="bi bi-list me-2"></i> Liste
                        </a>
                    </li>
               
                </ul>
            </nav>
        </div> 
    </header>
    
</body>
</html>