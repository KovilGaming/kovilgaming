<?php
if (isset($_FILES['media'])) {
    $file = $_FILES['media'];

    $targetDir = 'uploads/';

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = time() . '_' . $file['name'];

    $targetPath = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo 'Upload successful!';
    } else {
        echo 'Upload failed.';
    }
    header('Location: galeria.php');
    exit();
}
?>
