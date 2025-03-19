<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

$stmt = $pdo->prepare("SELECT * FROM files WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملفاتي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">ملفاتي</h1>
        <div class="row">
            <?php foreach ($files as $file): ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $file['file_name']; ?></h5>
                            <p class="card-text">تم الرفع في: <?php echo $file['created_at']; ?></p>
                            <a href="download.php?code=<?php echo $file['download_code']; ?>" class="btn btn-primary">تحميل</a>
                            <a href="delete_file.php?id=<?php echo $file['id']; ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>