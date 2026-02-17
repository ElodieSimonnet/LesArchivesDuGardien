<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {

    // Sécurité CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: ../../profile.php?error=security");
        exit();
    }

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {

        // Limite de taille : 2 Mo maximum
        if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            header("Location: ../../profile.php?error=file_too_large");
            exit();
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $fileInfo = pathinfo($_FILES['avatar']['name']);
        $extension = strtolower($fileInfo['extension']);

        if (in_array($extension, $allowedExtensions)) {

            $tmpFile = $_FILES['avatar']['tmp_name'];

            // Validation du MIME type réel du fichier
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($tmpFile);
            if (!in_array($mimeType, $allowedMimes)) {
                header("Location: ../../profile.php?error=invalid_format");
                exit();
            }

            // Vérification que c'est une vraie image
            if (getimagesize($tmpFile) === false) {
                header("Location: ../../profile.php?error=invalid_format");
                exit();
            }

            // Génére un nom de fichier unique (ex: avatar_1_65afb2.png)
            $newFileName = "avatar_" . $_SESSION['user_id'] . "_" . substr(md5(uniqid()), 0, 6) . "." . $extension;

            // Chemin physique pour déplacer le fichier
            $uploadDir = "../../assets/avatars/";
            $destination = $uploadDir . $newFileName;

            // Déplacement du fichier du dossier temporaire vers le dossier final
            if (move_uploaded_file($tmpFile, $destination)) {
                
                // Mise à jour de la base de données
                // On stocke le chemin relatif pour l'affichage HTML
                $dbPath = "assets/avatars/" . $newFileName;
                $stmt = $db->prepare("UPDATE adg_users SET avatar = ? WHERE id = ?");
                $stmt->execute([$dbPath, $_SESSION['user_id']]);

                header("Location: ../../profile.php?success=avatar_updated");
                exit();
            } else {
                header("Location: ../../profile.php?error=upload_failed");
                exit();
            }
        } else {
            header("Location: ../../profile.php?error=invalid_format");
            exit();
        }
    }
}
header("Location: ../../profile.php");
exit();