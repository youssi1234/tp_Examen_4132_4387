<?php
include('../inc/connexion.php');

function insert_membre($membre)
{
    $sqlInsert = "INSERT INTO exam_membre (email,mdp,nom,ddns,genre,ville) VALUES( 
        '%s', '%s', '%s', '%s' , '%s', '%s'
        );";
    $sqlInsert = sprintf($sqlInsert, $membre['email'], $membre['mdp'], $membre['nom'], $membre['ddns'], $membre['genre'], $membre['ville'] );
    $result = mysqli_query(dbconnect(), $sqlInsert);
}

function verif_membre($membre)
{
    $sql = "SELECT * FROM exam_membre WHERE Email = '%s'";
    $sql = sprintf($sql, $membre['Email']);
    $membre_req = mysqli_query(dbconnect(), $sql);

    if (mysqli_num_rows($membre_req) > 0) {
        mysqli_free_result($membre_req);
        return true;
    } else if (mysqli_num_rows($membre_req) == 0) {
        mysqli_free_result($membre_req);
        return false;
    }
}


function get_membre($membre)
{
    $sql = "SELECT * FROM exam_membre WHERE email = '%s' AND mdp = '%s'";
    $sql = sprintf($sql, $membre['email'], $membre['mdp']);
    $membre_req = mysqli_query(dbconnect(), $sql);

    $result = array();
    while ($membre = mysqli_fetch_assoc($membre_req)) {
        $result['id_membre'] = $membre['id_membre'];
        $result['nom'] = $membre['nom'];
        $result['genre'] = $membre['genre'];
        $result['ville'] = $membre['ville'];
        $result['email'] = $membre['email'];
        $result['ddns'] = $membre['ddns'];
        $result['image_profil'] = $membre['image_profil'];
    }
    mysqli_free_result($membre_req);
    return $result;
}


// function get_all_membre($idmandefa)
// {
//     $sql1 = "SELECT idMembre, Nom, Email 
//     FROM Membres 
//     WHERE idMembre != '%s'
//     AND idMembre NOT IN (
//         SELECT idAutre FROM (
//             SELECT idMembre2 AS idAutre 
//             FROM amis 
//             WHERE idMembre1 = '%s' AND DateHeureAcceptation IS NOT NULL
//             UNION 
//             SELECT idMembre1 AS idAutre 
//             FROM amis 
//             WHERE idMembre2 = '%s' AND DateHeureAcceptation IS NOT NULL
//         ) AS t
//     )";

//     $sql1 = sprintf($sql1, $idmandefa, $idmandefa, $idmandefa);
//     $member_req = mysqli_query(dbconnect(), $sql1);

//     $result = array();
//     while ($pers = mysqli_fetch_assoc($member_req)) {
//         $result[] = $pers;
//     }
//     mysqli_free_result($member_req);
//     return $result;
// }


function get_liste_objet()
{
    $conn = dbconnect();

    $sql = "SELECT
                obj.id_objet,
                obj.nom_objet,
                cat.nom_categorie,
                emp.date_retour
            FROM
                exam_objet AS obj
            JOIN
                exam_categorie_objet AS cat ON obj.id_categorie = cat.id_categorie
            LEFT JOIN
                exam_emprunt AS emp ON obj.id_objet = emp.id_objet;"; 

    $result = mysqli_query($conn, $sql);

    $objet = array();
    while ($donne = mysqli_fetch_assoc($result)) {
        $objet[] = $donne;
    }

    mysqli_free_result($result);
    return $objet;
}

function get_liste_categorie(){
    $conn = dbconnect();

    $sql = "SELECT
                *
            FROM
                exam_categorie_objet;"; 

    $result = mysqli_query($conn, $sql);

    $objet = array();
    while ($donne = mysqli_fetch_assoc($result)) {
        $objet[] = $donne;
    }

    mysqli_free_result($result);
    return $objet;
}

function create_v_obj_lib(){
    $sql = "CREATE OR REPLACE VIEW exam_v_obj_lib AS
            SELECT
                obj.id_objet,
                obj.nom_objet,
                cat.nom_categorie,
                cat.id_categorie,
                emp.date_retour,
                mb.nom          
            FROM exam_objet AS obj
            JOIN exam_categorie_objet AS cat 
            ON obj.id_categorie = cat.id_categorie
            LEFT JOIN exam_emprunt AS emp 
            ON obj.id_objet = emp.id_objet
            LEFT JOIN exam_membre AS mb 
            ON obj.id_membre = mb.id_membre;";

    if (!mysqli_query(dbconnect(), $sql)) {
        die('Erreur lors de la création de la vue v_emp_lib : ' . mysqli_error(dbconnect()));
    }
}


function get_all_obj_lib($id_cat){
    create_v_obj_lib();

    $sql = "SELECT
                *
            FROM exam_v_obj_lib AS lib
            WHERE lib.id_categorie = '%s';";

    $query_to_execute = sprintf($sql, $id_cat);
    $lib_req = mysqli_query(dbconnect(), $query_to_execute);

    $result = array();
    while($donnee = mysqli_fetch_assoc($lib_req)){
        $result[] = $donnee;
    }
    mysqli_free_result($lib_req);
    return $result;
}
?>