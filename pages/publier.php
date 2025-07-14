<?php
include('../inc/function.php');
session_start();
require_once '../inc/header.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>

  </style>
</head>
<body>


  <div class="main container">
    <div class="feed">
      <h2>Publier une photo</h2>

<form action="../inc/trait_upload.php" method="POST" enctype="multipart/form-data">        <label for="media">Sélectionnez une image ou une vidéo :</label>
        <input type="file" id="media" name="media" accept="image/*" required>
        <button type="submit">Publier</button>
      </form>
    </div>
  </div>

</body>
</html>

<?php
require_once '../inc/footer.php';
?>