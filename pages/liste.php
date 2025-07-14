<?php
$pageTitle = "Liste des Objets";
require_once '../inc/header.php';
include('../inc/function.php'); 

$objet = get_liste_objet();
?>

<!-- Bootstrap requis -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<main class="container mt-4 mb-5">
    <h2 class="text-center mb-4">Liste des Objets et emprunt</h2>

    <div class="row">
        <article class="col-lg-9 col-md-8 p-3 bg-white rounded shadow-sm">
            <?php if (!empty($objet)) { ?>
            <div class="table-responsive"> 
                <table class="employee table table-striped table-hover table-bordered caption-top">
                    <caption class="text-start">Liste des départements avec leurs managers et le nombre d'employés.</caption>
                    
                    <thead> 
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Nom Categorie</th>
                            <th scope="col">Date de retour</th>
                            <th scope="col">Emprunter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($objet as $donnees) { ?>
                        <tr>
                            <td>
                                <a href="../inc/trait_fiche.php?id_ob=<?php echo $donnees['id_objet']; ?>">
                                    <i class="bi bi-info-circle info-puce"></i>
                                </a>
                                <?php echo $donnees['nom_objet']; ?>
                            </td>

                            <td><?php echo $donnees['nom_categorie']; ?></td>
                            <td>
                                <?php if ($donnees['date_retour'] != NULL) {
                                    echo $donnees['date_retour'];
                                } else {
                                    echo "-";
                                } ?>
                            </td>

                            <td>
                                <!-- Icône Bootstrap pour ouvrir le offcanvas -->
                                <i class="bi bi-bag-plus-fill info-puce"
                                   style="cursor:pointer;"
                                   data-bs-toggle="offcanvas"
                                   data-bs-target="#empruntOffcanvas"
                                   onclick="setObjetId(<?php echo $donnees['id_objet']; ?>)">
                                </i>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <div class="alert alert-info text-center" role="alert">
                    Aucun département n'a été trouvé dans la base de données.
                </div>
            <?php } ?>
        </article>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="empruntOffcanvas" aria-labelledby="empruntOffcanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="empruntOffcanvasLabel">Définir la date d'emprunt</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <form action="../inc/trait_emprunt.php" method="post">
            <input type="hidden" name="id_objet" id="offcanvas-id-objet">
            <div class="mb-3">
                <label for="date_emprunt" class="form-label">Date d'emprunt :</label>
                <input type="date" name="date_emprunt" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Valider</button>
        </form>
      </div>
    </div>
</main>


