<?php
include('../inc/function.php');
session_start();

$mail = $_POST['email'];
$mdp = $_POST['mdp'];

$membre = array(
    'email' => $mail,
    'mdp' => $mdp
);

$result = get_membre($membre);

if ($result != null) {
        $_SESSION['idMembre'] = $result['id_membre'];
        $_SESSION['nom'] = $result['nom'];
        $_SESSION['ddns'] = $result['ddns'];
        $_SESSION['email'] = $result['email'];

        // echo($result['idMembre']);
    header('Location:../pages/liste.php');
}

else if($result == null){ 
    header('Location:../pages/formulaire.php?erreur=1');    
    exit();
}   













?>