<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

if (isset($_GET['id'])) {
    $fileId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM files WHERE id = ? AND user_id = ?");
    $stmt->execute([$fileId, $_SESSION['user_id']]);
    $file = $stmt->fetch();

    if ($file) {
        unlink($file['file_path']);
        $stmt = $pdo->prepare("DELETE FROM files WHERE id = ?");
        $stmt->execute([$fileId]);
        redirect('my_files.php');
    } else {
        echo "الملف غير موجود أو لا يخصك.";
    }
} else {
    echo "طلب غير صحيح.";
}
?>