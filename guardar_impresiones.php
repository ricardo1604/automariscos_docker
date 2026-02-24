<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $targetDir = 'impresiones/';
    $targetFile = $targetDir . basename($_FILES['file']['name']);
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo $targetFile;
    } else {
        echo 'Error saving file.';
    }
} else {
    echo 'Invalid request.';
}
?>
