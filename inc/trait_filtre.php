<?php
include('../inc/function.php');
session_start();

$id_cat = $_POST['id_categorie'];


// $result = get_all_obj_lib($id_cat);

// var_dump ($result);

    header("Location:../pages/filtre.php?success=1&id=". urlencode($id_cat));    










?>