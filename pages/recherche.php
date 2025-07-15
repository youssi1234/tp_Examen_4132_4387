<?php
$pageTitle = "Recherche d'objets";
require_once '../inc/header.php';

include('../inc/function.php');
session_start();

$catg = get_liste_categorie();

$selected_categorie_id = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$selected_nom_objet = isset($_GET['nom']) ? $_GET['nom'] : '';
$checkbox_disponible = isset($_GET['check_categorie']) && $_GET['check_categorie'] == '1';

?>

<main class="container mt-4 p-3 bg-light rounded shadow-sm">
    <h2 class="text-center mb-4">Rechercher des objets</h2>

    <section class="mb-4">
        <form action="../inc/trait_search.php" method="post" class="row g-3 align-items-end justify-content-center">

            <div class="col-md-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select class="form-select" id="categorie" name="categorie">
                    <option value="">Toutes les catégories</option>
                <?php foreach ($catg as $donnees) { ?>
                    <option value="<?= $donnees['id_categorie'] ?>" <?php echo ($donnees['id_categorie'] == $selected_categorie_id) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($donnees['nom_categorie']) ?>
                    </option>
                <?php } ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="nom" class="form-label">Nom de l'objet</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom de l'objet" value="<?php echo htmlspecialchars($selected_nom_objet); ?>" />
            </div>

            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkDisponible" name="check_categorie" value="1" <?php echo $checkbox_disponible ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="checkDisponible">
                        Disponible
                    </label>
                </div>
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>
    </section>

    <?php
    if (isset($_GET['research']) && $_GET['research'] == 1 && isset($_SESSION['info'])) {
        $info = $_SESSION['info'];
        $research = get_result_research($info['nom'], $info['categorie'], $info['check_categorie']);
    ?>

        <section class="mt-4">
            <?php if (!empty($research)) { ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered caption-top">
                        <caption>Résultats de la recherche (<?php echo count($research); ?> trouvé(s))</caption>
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID Objet</th>
                                <th scope="col">Nom de l'objet</th>
                                <th scope="col">Catégorie</th>
                                <th scope="col">Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($research as $donnees) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($donnees['id_objet']); ?></td>
                                    <td><?php echo htmlspecialchars($donnees['nom_objet']); ?></td>
                                    <td><?php echo htmlspecialchars($donnees['nom_categorie']); ?></td>
                                    <td><?php echo htmlspecialchars($donnees['est_disponible']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning text-center" role="alert">
                    Aucun résultat trouvé pour votre recherche.
                </div>
            <?php } ?>
        </section>

    <?php } else { ?>
        <div class="alert alert-info text-center mt-5" role="alert">
            Veuillez effectuer une recherche pour afficher les résultats.
        </div>
    <?php } ?>

</main>