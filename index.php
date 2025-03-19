<?php
session_start();
include 'includes/config.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('pages/login.php');
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">ScreenMix</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/upload.php">رفع ملف</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/my_files.php">ملفاتي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/profile.php">الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">مرحباً بك في ScreenMix</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">رفع الملفات</h5>
                        <p class="card-text">يمكنك رفع الملفات ومشاركتها مع الآخرين بسهولة.</p>
                        <a href="pages/upload.php" class="btn btn-primary">رفع ملف</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">ملفاتي</h5>
                        <p class="card-text">إدارة الملفات التي قمت برفعها.</p>
                        <a href="pages/my_files.php" class="btn btn-success">عرض الملفات</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>