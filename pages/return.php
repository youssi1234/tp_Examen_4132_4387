<?php
include('../inc/function.php');
session_start();

$id_membre = $_SESSION['idMembre'];
$id_emp = $_GET['id_emp'];
$emprunt = get_desc_emprunt($id_membre,$id_emp);

require_once '../inc/header.php'; 

?>

    <main class="main-container">
        <div class="contain"> 
            <div class="contener"> 
                <div class="titre">

                </div>
                <div class="button-group">
                    <div>
                        <button class="action-button"><a href="../inc/trait_back.php?val=0&id=<?php$id_emp;?>">OK</a></button>
                    </div>
                    <div>
                        <button class="action-button"><a href="../inc/trait_back.php?val=1&id=<?php$id_emp;?>">Abimée</a></button>
                    </div>
                </div>
            </div>
        </div>
    </main>