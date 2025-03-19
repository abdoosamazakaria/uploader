<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    if (!is_dir('../uploads')) {
        mkdir('../uploads');
    }

    if ($fileError === 0) {
        $fileNewName = uniqid('', true) . '-' . $fileName;
        $fileDestination = '../uploads/' . $fileNewName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $downloadCode = generateDownloadCode();
            $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

            $stmt = $pdo->prepare("INSERT INTO files (user_id, file_name, file_path, download_code, expires_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $fileName, $fileDestination, $downloadCode, $expiresAt]);

            echo "تم رفع الملف بنجاح! رابط التحميل: <a href='download.php?code=$downloadCode'>هنا</a>";
        } else {
            echo "حدث خطأ أثناء رفع الملف.";
        }
    } else {
        echo "حدث خطأ أثناء رفع الملف.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفع ملف</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">رفع ملف</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit" class="btn btn-primary">رفع</button>
        </form>
    </div>
</body>
</html>