<?php
session_start();

$id_obj = $_GET['id_ob'];
$_SESSION['id_objet_rech'] = $id_obj;

// echo $id_obj;
    header('Location:../pages/fiche.php');
?>