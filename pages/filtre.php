<?php
session_start(); // Assurez-vous que session_start() est bien au début si nécessaire
$pageTitle = "Liste des Objets";
require_once '../inc/header.php';
include('../inc/function.php'); // Assurez-vous que get_liste_objet() et get_liste_categorie() sont définies dans ce fichier

// Récupère la liste des catégories pour le filtre
$liste_categories = get_liste_categorie();


?>

<main class="container mt-5 p-3 rounded">
    <div class="mb-4">
        <button type="button" class="btn btn-outline-primary"
            data-bs-toggle="collapse"
            data-bs-target="#form-add-dept"
            aria-expanded="false"
            aria-controls="form-add-dept">
            Filtrer par Catégorie
        </button>
        
        <div class="collapse mt-3" id="form-add-dept">
            <div class="card card-body">
                <form action="../inc/trait_filtre.php" method="post">
                    <div class="mb-3">
                        <label for="dept_name" class="form-label">Choisir une catégorie</label>
                        <select class="form-select" id="dept_name" name="id_categorie">
                            <?php foreach ($liste_categories as $cat) { ?>
                                <option value="<?= htmlspecialchars($cat['id_categorie']) ?>"><?= htmlspecialchars($cat['nom_categorie']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Filtrer</button>
                </form>
            </div>
        </div>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                <div class="table-responsive">
        <table class="employee table table-striped table-hover table-bordered caption-top">
            <caption class="text-start">Liste de tous les objets disponibles avec leur catégorie et la date de retour (si emprunté).</caption>

            <thead>
                <tr>
                    <th scope="col">Nom Objet</th>
                    <th scope="col">Nom Catégorie</th>
                    <th scope="col">Nom Personne</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = get_all_obj_lib($_GET['id']);

                if (!empty($result)) {
                    foreach ($result as $donnee) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($donnee['nom_objet']); ?></td>
                            <td><?php echo htmlspecialchars($donnee['nom_categorie']); ?></td>
                            <td><?php echo htmlspecialchars($donnee['nom'] ); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    // Message si aucun objet n'est trouvé
                    ?>
                    <tr>
                        <td colspan="3">Aucun objet trouvé.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
            <?php } ?>
    </div>

    
</main>

<?php
require_once '../inc/footer.php';
?>
