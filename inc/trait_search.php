<?php
include('../inc/function.php');
session_start();

if(isset($_POST['categorie']) || isset($_POST['nom']) || isset($_POST['check_categorie'])) { 
    $_SESSION['info'] = array(
        'categorie' => $_POST['categorie'] ?? '', 
        'nom' => $_POST['nom'] ?? '',
        'check_categorie' => $_POST['check_categorie'] ?? '', 
    );
} else {
    $_SESSION['info'] = array(
        'categorie' => '',
        'nom' => '',
        'check_categorie' => '',
    );
}


header("Location: ../pages/recherche.php?research=1"); 

?>