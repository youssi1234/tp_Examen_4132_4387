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

function get_desc_membre($id_membre)
{
    $sql = "SELECT * FROM exam_membre WHERE id_membre = '%s';";
    $sql = sprintf($sql,$id_membre);
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
                mb.nom,
                mb.genre          
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


function create_v_obj_all_lib(){
    $sql = "CREATE OR REPLACE VIEW exam_v_obj_all_lib AS
            SELECT
                img.id_objet, img.nom_image         
            FROM exam_v_obj_lib AS lib
            LEFT JOIN exam_images_objet AS img
            ON lib.id_objet = img.id_objet;";

    if (!mysqli_query(dbconnect(), $sql)) {
        die('Erreur lors de la création de la vue v_emp_lib : ' . mysqli_error(dbconnect()));
    }
}



function get_obj_desc($id_obj){
    create_v_obj_lib();

    $sql = "SELECT
            *
            FROM exam_v_obj_lib AS lib
            WHERE lib.id_objet = '%s';";

    $query_to_execute = sprintf($sql, $id_obj);
    $lib_req = mysqli_query(dbconnect(), $query_to_execute);

    $result = array();
    while($donnee = mysqli_fetch_assoc($lib_req)){
        $result['nom'] = $donnee['nom'];
        $result['nom_categorie'] = $donnee['nom_categorie'];
        $result['nom_objet'] = $donnee['nom_objet'];
    }
    mysqli_free_result($lib_req);
    return $result;
}



function get_historic_emprunt($id_obj){
    $sql = " SELECT
                emp.id_emprunt, emp.date_emprunt, emp.date_retour
                from exam_emprunt as emp
                where emp.id_objet = '%s'
                ORDER BY emp.date_emprunt DESC;";

    $query_to_execute = sprintf($sql, $id_obj);
    $req = mysqli_query(dbconnect(), $query_to_execute);

    $result = array();
    while($donnee = mysqli_fetch_assoc($req)){
        $result[] = $donnee;
    }
    mysqli_free_result($req);
    return $result;
}


function get_historic_desc_emprunt($id_membre){
    $sql = " SELECT
                emp.id_emprunt, emp.date_emprunt, emp.date_retour
                from exam_emprunt as emp
                where emp.id_membre = '%s'
                ORDER BY emp.date_emprunt DESC;";

    $query_to_execute = sprintf($sql, $id_membre);
    $req = mysqli_query(dbconnect(), $query_to_execute);

    $result = array();
    while($donnee = mysqli_fetch_assoc($req)){
        $result[] = $donnee;
    }
    mysqli_free_result($req);
    return $result;
}

function get_result_research($nom, $categorie, $check) {
    $bdd = dbconnect(); 

    $sql = "
        SELECT
            obj.id_objet,
            obj.nom_objet,
            cat.nom_categorie,
            cat.id_categorie,
            emp.date_retour,
            mb.nom,
            CASE
                WHEN emp.date_retour IS NULL THEN 'Non'
                ELSE 'Oui'
            END AS est_disponible
        FROM exam_objet AS obj
        JOIN exam_categorie_objet AS cat
        ON obj.id_categorie = cat.id_categorie
        LEFT JOIN exam_emprunt AS emp
        ON obj.id_objet = emp.id_objet AND emp.date_retour IS NULL -- Important : pour l'état d'emprunt actuel
        LEFT JOIN exam_membre AS mb
        ON emp.id_membre = mb.id_membre -- Correction: mb.id_membre joint avec emp.id_membre
        WHERE 1=1"; 
    if (!empty($nom) && empty($categorie) && empty($check)) {
        $sql .= " AND obj.nom_objet LIKE '%$nom%'";

    } else if (empty($nom) && !empty($categorie) && empty($check)) {
        $sql .= " AND cat.id_categorie = $categorie"; 
    } else if (empty($nom) && empty($categorie) && !empty($check)) {
        $sql .= " AND emp.id_objet IS NULL"; 
    } else if (!empty($nom) && !empty($categorie) && empty($check)) {
        $sql .= " AND obj.nom_objet LIKE '%$nom%'";
        $sql .= " AND cat.id_categorie = $categorie";
    } else if (!empty($nom) && empty($categorie) && !empty($check)) {
        $sql .= " AND obj.nom_objet LIKE '%$nom%'";
        $sql .= " AND emp.id_objet IS NULL";
    } else if (empty($nom) && !empty($categorie) && !empty($check)) {
        $sql .= " AND cat.id_categorie = $categorie";
        $sql .= " AND emp.id_objet IS NULL";
    } else if (!empty($nom) && !empty($categorie) && !empty($check)) {
        $sql .= " AND obj.nom_objet LIKE '%$nom%'";
        $sql .= " AND cat.id_categorie = $categorie";
        $sql .= " AND emp.id_objet IS NULL";
    } else {
    }


    $sql .= " ORDER BY obj.nom_objet ASC"; 

    $result = mysqli_query($bdd, $sql);

    if (!$result) {
        die("Erreur de requête SQL : " . mysqli_error($bdd) . "<br>Requête exécutée : " . $sql);
    }

    $research = array();
    while($donnee = mysqli_fetch_assoc($result)){
        $research[] = $donnee;
    }

    mysqli_free_result($result);
    mysqli_close($bdd); 
    
    
    return $research;
}

function enprunt($id_obj ,$id_membre , $date) {
    $sql = "INSERT INTO exam_emprunt VALUES 
    (%d , %d , now() , $date);";
    $sql = sprintf($sql , $id_obj ,$id_membre , $date );
    $result = mysqli_query(dbconnect(), $sql);
    if($result) {
        return true;

    }else {
       echo " Erreur de requête SQL : " . mysqli_error($bdd) . "<br>Requête exécutée : " . $sql ;
    }
}


function get_desc_emprunt($id_membre,$id_emp){
    $sql = " SELECT
                emp.id_emprunt, emp.date_emprunt, emp.date_retour
                from exam_emprunt as emp
                where emp.id_membre = '%s' and emp.id_emprunt = '%s'
                ORDER BY emp.date_emprunt DESC;";

    $query_to_execute = sprintf($sql, $id_membre,$id_emp);
    $req = mysqli_query(dbconnect(), $query_to_execute);

    $result = array();
    while($donnee = mysqli_fetch_assoc($req)){
        $result[] = $donnee;
    }
    mysqli_free_result($req);
    return $result;
}

function modif_statut_emprunt($val, $id_emp){
    $sql = "UPDATE exam_emprunt
                set statut = '%s', date_retour = CURDATE()
                Where id_emprunt = '%s';";
    $query_to_execute = sprintf($sql, $val,$id_emp);
    $req = mysqli_query(dbconnect(), $query_to_execute); 
}
?>