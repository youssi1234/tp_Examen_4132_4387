<?php
include('../inc/function.php');
session_start();

$id_obj = $_SESSION['id_objet_rech'];

$objet = get_obj_desc ($id_obj);

$emprunt = get_historic_emprunt($id_obj);

//
// $pageTitle = htmlspecialchars($objet['dept_name'] . ' - ' . $objet['emp_no']);
require_once '../inc/header.php'; 


?>
  
    <main class="container mt-5 p-3 rounded"> 
            <section class="row">
                <aside class="col-2 justify-content-end"> 
                    <button type="button" class="lien btn btn-outline-primary"><a href="../pages/liste.php">Precedent</a></button>
                    <button type="button" class="lien btn btn-outline-primary"><a href="../pages/publier.php?id=<?php $id_obj; ?>">Upload</a></button>
                </aside>

                <section class="col-md-10 d-flex justify-content-center">
                    <?php if (!empty($objet)): ?>
                        <article class="card" style="width: 30rem;">
                            <div class="card-body row">
                    
                            <div class="identite col-4">
                                    <i class="bi bi-person-badge-fill"></i>                                
                                </div>
                                <div class="col-8">
                                <h5 class="card-title"><?= $objet['nom_objet']; ?></h5>
                                
                                <p class="card-text" style="width:150px;"><i class="bi bi-person-check"></i> <?= $objet['nom']?>
                                </br><i class="bi bi-tags"></i></i> <?= $objet['nom_categorie']?>
                                    </div>
                            </div>
                        </article>

                    <?php else: ?>
                        <p class="alert alert-warning">objet $objet data not found.</p>
                    <?php endif; ?>
                </section>
            </section>

            <section class="row mt-5 col-12">
                <section class="col-md-6">
                    <article>
                        <h5 class="mb-3"
                            data-bs-toggle="collapse"
                            data-bs-target="#histo_salaire" aria-expanded="false"
                            aria-controls="#histo_salaire"    style="cursor: pointer;">
                            Historique emprunt
                            <i class="bi bi-chevron-down float-end"></i>
                        </h5>
                        <div class="collapse" id="histo_salaire">
                        <?php if (!empty($emprunt)): ?>
                            <table class="objet$objet table"> 
                                <thead>
                                    <tr>
                                        <th scope="col">Debut</th>
                                        <th scope="col">Fin</th>
                                        <th scope="col">id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($emprunt as $donnee){?>
                                        <tr>
                                            <td><?= $donnee['date_emprunt']?></td>
                                            <?php if ($donnee['date_retour'] != NULL) { ?>
                                <td><?php echo  $donnee['date_retour'];?></td>
                            <?php } else { ?>
                                <td> - </td> <?php }?>
                                            <td><?= $donnee['id_emprunt']?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="alert alert-info">No salary history available.</p>
                        <?php endif; ?>
                        </div>
                        </article>
            </section>

                
            </section>
        </main>




              