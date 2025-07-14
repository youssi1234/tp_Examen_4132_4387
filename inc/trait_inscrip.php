<?php
include('../inc/function.php');

$membre = array(
    'nom' => $_POST['nom'],
    'email' => $_POST['email'],
    'mdp' => $_POST['mdp'],
    'ddns' => $_POST['ddns'],
    'genre' => $_POST['genre'],
    'ville' => $_POST['ville']

);

if(verif_membre($membre) == true){
    header('Location:../pages/inscription.php?erreur=1');
    exit();
}
else if(verif_membre($membre) == false){
    insert_membre($membre);
    header('Location:../pages/formulaire.php');
    exit();
}




?>
