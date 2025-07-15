<?php
$pageTitle = "Liste des Objets";

require_once '../inc/header.php';
require_once '../inc/function.php';
$objets = get_liste_objet();

// Initialisation des variables si nécessaire (pour traitement ultérieur ou pour éviter des notices)
// Note: Le traitement de $_POST['id'] et $_POST['nb'] devrait idéalement être fait dans trait_emprunt.php
// ou dans un bloc de traitement POST dédié sur cette page si elle gère aussi des actions.
// Pour l'affichage de la liste, ces variables ne sont pas directement utilisées ici.
$id_post = $_POST['id'] ?? null;

?>
<main class="container mt-4 mb-5">
    <h2 class="text-center mb-4">Liste des Objets et emprunt</h2>

    <div class="row">
        <article class="col-lg-9 col-md-8 p-3 bg-white rounded shadow-sm">
            <?php if (!empty($objets)) { // Changé $objet en $objets pour plus de clarté et de cohérence 
            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Catégorie</th>
                                <th>Emprunt</th>
                                <th>Retour</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($objets as $donnees) { ?>
                                <tr>
                                    <td>
                                        <a href="../inc/trait_fiche.php?id_ob=<?php echo htmlspecialchars($donnees['id_objet']); ?>">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                        <?php echo htmlspecialchars($donnees['nom_objet']); ?>
                                    </td>

                                    <td><?php echo htmlspecialchars($donnees['nom_categorie']); ?></td>
                                    <td><?php echo htmlspecialchars($donnees['date_emprunt'] ?? "-"); ?></td>
                                    <td><?php echo htmlspecialchars($donnees['date_retour'] ?? "-"); ?></td>
                                    <td>
                                        <?php if ($donnees['date_retour'] != NULL || $donnees['date_emprunt'] == NULL) { ?>
                                            <button class="btn btn-link p-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-<?php echo htmlspecialchars($donnees['id_objet']); ?>">
                                                <i class="bi bi-bag-plus-fill text-success"></i>
                                            </button>

                                            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas-<?php echo htmlspecialchars($donnees['id_objet']); ?>">
                                                <div class="offcanvas-header">
                                                    <h5 class="offcanvas-title">Delai d'emprunt         ⏰</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                                </div>
                                                <div class="offcanvas-body">
                                                    <form action="../inc/trait_emprunt.php" method="post">
                                                        <input type="hidden" name="id_objet" value="<?php echo htmlspecialchars($donnees['id_objet']); ?>">
                                                        <div class="mb-3">
                                                            <label for="nb">Nombre de jours :</label>
                                                            <input type="number" name="nb" value="1" min="1" class="form-control" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="bi bi-patch-check"></i> Valider
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <span class="text-success">✔</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p class="alert alert-info text-center">Aucun objet disponible pour le moment.</p>
            <?php } ?>
        </article>
        <aside class="col-lg-3 col-md-4">
        </aside>
    </div>
</main>
<?php
require_once '../inc/footer.php';
?>