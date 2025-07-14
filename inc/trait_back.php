<?php
include('../inc/function.php');
session_start();

$value = $_GET['val'];
$id_emp = $_GET['id'];

modif_statut_emprunt($value,$id_emp);

echo "changement réussi";

header("Location: ../pages/fiche_membre.php"); 

?>

