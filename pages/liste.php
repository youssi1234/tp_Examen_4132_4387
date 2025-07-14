<?php
$pageTitle = "Liste des Objets";
require_once '../inc/header.php';
include('../inc/function.php'); 

$objet = get_liste_objet();
?>

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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($objet as $donnees) { ?>
                        
                        <tr>
                            <td><?php echo  $donnees['nom_objet']; ?></td>
                            <td><?php echo  $donnees['nom_categorie'];?></td>
                            <?php if ($donnees['date_retour'] != NULL) { ?>
                                <td><?php echo  $donnees['date_retour'];?></td>
                            <?php } else { ?>
                                <td> - </td> <?php }?>


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
</main>

<?php
// require_once '../inc/footer.php';
?>