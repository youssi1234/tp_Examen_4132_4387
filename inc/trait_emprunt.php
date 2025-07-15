<?php
include('../inc/function.php');
session_start();

if(isset($_POST['moin']) || isset($_POST['plus'])) {
$nb = isset($_POST['nb']) ? intval($_POST['nb']) : 1;

if(isset($_POST['plus'])) {
    $nb++;
} else if(isset($_POST['moins']) && $nb >1) {
    $nb = max(1, $nb -1);
}
header('Location:../pages/liste.php?nb=' . $nb);

} else if(isset($_POST['nb'])){
    $nb = $_POST['nb'];

// echo $nb;
// echo $_POST['id_objet'];
// echo $_SESSION['idMembre'];
    emprunt($_SESSION['id_objet_rech'], $_SESSION['idMembre'] , $nb);
    header('Location:../pages/liste.php?nb=' . $nb);
}




?>