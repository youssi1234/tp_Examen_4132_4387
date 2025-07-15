<?php
include('../inc/function.php');
session_start();


$id_membre = $_SESSION['idMembre'];

$pers = get_desc_membre ($id_membre);

$emprunt = get_historic_desc_emprunt($id_membre);

require_once '../inc/header.php'; 


?>
  
    <main class="container mt-5 p-3 rounded"> 
            <section class="row">
                <aside class="col-2 justify-content-end"> 
                    <button type="button" class="lien btn btn-outline-primary"><a href="../pages/liste.php">Precedent</a></button>
                    <button type="button" class="lien btn btn-outline-primary"><a href="../pages/publier.php?id=<?php $id_membre; ?>">Upload</a></button>
                </aside>

                <section class="col-md-10 d-flex justify-content-center">
                    <?php if (!empty($pers)): ?>
                        <article class="card" style="width: 30rem;">
                            <div class="card-body row">
                    
                            <div class="identite col-4">
                                <?php if (!empty($pers['image_profil'])) { ?>
                                    <img src="../assets/image/profil/<?php echo $pers['image_profil']; ?>" alt="Image de profil" class="img-fluid rounded margin-0">
                                    <?php } else { ?>
                                    <i class="bi bi-person-badge-fill"></i>
                                    <?php } ?>
                                </div>
                                <div class="col-8">
                                <h5 class="card-title"><?= $pers['nom']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">
                                    <?php if($pers['genre'] == 'F'){?>    
                                <i class="bi bi-gender-female"></i> 
                                <?php } else { ?>
                                <i class="bi bi-gender-male"></i> 
                                <?php } ?>
                                <?= $pers['genre']?></h6>
                                
                                <p class="card-text" style="width:150px;"><i class="bi bi-cake"></i> <?= $pers['ddns']?>
                                </br><i class="bi bi-envelope-at"></i> <?= $pers['email']?>
                                </br><i class="bi bi-house-gear-fill"></i> <?= $pers['ville']?>
                                    </div>
                            </div>
                            </div>
                        </article>

                    <?php else: ?>
                        <p class="alert alert-warning">$pers data not found.</p>
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
                            <table class="pers$pers table"> 
                                <thead>
                                    <tr>
                                        <th scope="col">Debut</th>
                                        <th scope="col">Fin</th>
                                        <th scope="col">id</th>
                                        <th scope="col">Retour</th>
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
                                            <td><a href="../pages/return.php?id_emp=<?= $donnee['id_emprunt']?>"><i class="bi-arrow-counterclockwise"></i></a></td>

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




              