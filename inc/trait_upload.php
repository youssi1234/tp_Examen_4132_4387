<?php
session_start();
include('../inc/function.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/publier.php');
    exit();
}



$userId = $_SESSION['idMembre'];

$pubData = array(
    'idMembre'  => $userId
);

$publicationId = insert_publication($pubData); // Appelle la fonction de function2.php
if (!$publicationId) {
    die('Erreur lors de l\'insertion de la publication dans la base de données.'); // Gère l'erreur d'insertion
}

if (!isset($_FILES['media'])) { // Vérifie si un fichier a été envoyé
    die('Aucun fichier n\'a été envoyé.');
}

$file = $_FILES['media']; // Récupère toutes les informations sur le fichier téléchargé

if ($file['error'] !== UPLOAD_ERR_OK) { // Vérifie s'il y a eu une erreur d'upload côté serveur
    die('Erreur lors de l’upload : ' . $file['error']);
}

// 10. Définition des chemins de stockage et des règles de validation
$uploadDirRelativeImage = '../assets/images/uploads/publication/'; // Chemin relatif pour les images
$uploadDirRelativeVideo = '../assets/videos/uploads/publication/'; // Chemin relatif pour les vidéos (créé un sous-dossier pour meilleure organisation)
$uploadDirAbsoluteImage = __DIR__ . '/' . $uploadDirRelativeImage; // Chemin absolu pour les images
$uploadDirAbsoluteVideo = __DIR__ . '/' . $uploadDirRelativeVideo; // Chemin absolu pour les vidéos

$maxSizeImage = 10 * 1024 * 1024; // 10 Mo pour les images
$maxSizeVideo = 100 * 1024 * 1024; // 100 Mo pour les vidéos

$allowedMimeTypesImage = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']; // Types MIME autorisés pour les images
$allowedMimeTypesVideo = ['video/mp4', 'video/webm', 'video/ogg']; // Types MIME autorisés pour les vidéos

// 11. Vérification et création des répertoires de destination
// `is_dir()` : vérifie si le répertoire existe
// `mkdir()` : crée le répertoire. Le 'true' final permet la création récursive (crée les dossiers parents si besoin)
// `is_writable()` : vérifie si le serveur a les permissions d'écrire dans le répertoire
if (!is_dir($uploadDirAbsoluteImage) && !mkdir($uploadDirAbsoluteImage, 0755, true)) {
    die('Erreur : Impossible de créer le répertoire d\'upload pour les images.');
}
if (!is_writable($uploadDirAbsoluteImage)) {
    die('Erreur : Le répertoire d\'upload des images n\'est pas accessible en écriture.');
}
if (!is_dir($uploadDirAbsoluteVideo) && !mkdir($uploadDirAbsoluteVideo, 0755, true)) {
    die('Erreur : Impossible de créer le répertoire d\'upload pour les vidéos.');
}
if (!is_writable($uploadDirAbsoluteVideo)) {
    die('Erreur : Le répertoire d\'upload des vidéos n\'est pas accessible en écriture.');
}

// 12. Détermination du type MIME réel du fichier (sécurisé)
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Ouvre une ressource pour détecter le type MIME
$mime = finfo_file($finfo, $file['tmp_name']); // Détecte le type MIME du fichier temporaire
finfo_close($finfo); // Ferme la ressource

// 13. Préparation du nom du fichier
$originalName = pathinfo($file['name'], PATHINFO_FILENAME); // Nom du fichier sans extension
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);   // Extension du fichier
$newName = $userId . '_' . uniqid() . '.' . $extension; // Crée un nom de fichier unique : ID_utilisateur_identifiant_unique.extension

$uploadedFileName = null; // Variable pour stocker le nom final du fichier à insérer en DB
$updateFunction = null;   // Variable pour stocker la fonction de mise à jour DB à appeler

// 14. Validation du type et de la taille du fichier, et définition du chemin de destination
if (in_array($mime, $allowedMimeTypesImage)) { // Si le MIME est une image autorisée
    if ($file['size'] > $maxSizeImage) {
        die('L\'image est trop volumineuse.');
    }
    $destinationPathAbsolute = $uploadDirAbsoluteImage . $newName; // Chemin absolu de destination pour l'image
    $uploadedFileName = $newName; // Nom de l'image pour la base de données
    $updateFunction = 'update_pub_image'; // Fonction à appeler pour mettre à jour la publication

} elseif (in_array($mime, $allowedMimeTypesVideo)) { // Si le MIME est une vidéo autorisée
    if ($file['size'] > $maxSizeVideo) {
        die('La vidéo est trop volumineuse.');
    }
    $destinationPathAbsolute = $uploadDirAbsoluteVideo . $newName; // Chemin absolu de destination pour la vidéo
    $uploadedFileName = $newName; // Nom de la vidéo pour la base de données
    $updateFunction = 'update_pub_video'; // Fonction à appeler pour mettre à jour la publication

} else {
    die('Type de fichier non autorisé : ' . $mime); // Si le type MIME n'est ni image ni vidéo autorisée
}

// 15. Déplacement du fichier temporaire vers sa destination finale
if ($uploadedFileName && move_uploaded_file($file['tmp_name'], $destinationPathAbsolute)) {
    // Si le fichier a été déplacé avec succès et qu'un nom a été généré

    // 16. Met à jour la base de données avec le nom du fichier (image ou vidéo)
    if (function_exists($updateFunction)) { // Vérifie si la fonction de mise à jour existe
        if ($updateFunction($uploadedFileName, $publicationId, $userId)) { // Appelle la fonction de mise à jour
            // 17. Succès : Redirection de l'utilisateur
            echo $newName;
            header('Location: ../pages/accueil.php'); // Redirige vers le profil avec un paramètre de succès
            exit(); // Termine le script immédiatement après la redirection
        } else {
            // 18. Erreur de mise à jour DB : Nettoyage
            unlink($destinationPathAbsolute); // Supprime le fichier qui vient d'être téléchargé car l'insertion DB a échoué
            die('Erreur lors de la mise à jour de la base de données.');
        }
    } else {
        // 19. Erreur : Fonction de mise à jour manquante
        unlink($destinationPathAbsolute); // Supprime le fichier téléchargé
        die('Fonction de mise à jour de la publication introuvable.');
    }
} else {
    // 20. Échec du déplacement du fichier
    die('Échec du déplacement du fichier vers le répertoire de destination.');
}

?>