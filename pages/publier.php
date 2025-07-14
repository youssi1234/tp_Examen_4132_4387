<?php
include('../inc/function.php');
session_start();
require_once '../inc/header.php'; // This should include your <head> section and link to an external CSS file
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
<body>

    <div class="main-container"> <div class="feed upload-section"> <h2>Publier une photo</h2>

            <form action="../inc/trait_upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
                <input type="file" id="media" name="media" accept="image/*,video/*" required>
                <label for="media" class="custom-file-upload-button">Sélectionnez une image</label>
                
                <button type="submit" class="submit-button">Publier</button>
            </form>
        </div>
    </div>

</body>
</html>

<?php
require_once '../inc/footer.php';
?>