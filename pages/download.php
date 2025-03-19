<?php
session_start();
include '../includes/config.php';

if (isset($_GET['code'])) {
    $downloadCode = $_GET['code'];

    $stmt = $pdo->prepare("SELECT files.*, users.username, users.profile_picture, users.country, users.device_type FROM files LEFT JOIN users ON files.user_id = users.id WHERE download_code = ? AND expires_at > NOW()");
    $stmt->execute([$downloadCode]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        ?>
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>تحميل الملف</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                .file-info {
                    border: 1px solid #ddd;
                    padding: 20px;
                    border-radius: 10px;
                    background-color: #f9f9f9;
                }
                .file-info img {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                }
            </style>
        </head>
        <body class="bg-light">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container">
                    <a class="navbar-brand" href="../index.php">ScreenMix</a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="upload.php">رفع ملف</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="my_files.php">ملفاتي</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">الملف الشخصي</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container mt-5">
                <h1 class="text-center">معلومات الملف</h1>
                <div class="file-info text-center">
                    <img src="<?php echo $file['profile_picture'] ?? 'https://via.placeholder.com/150'; ?>" alt="صورة الملف الشخصي">
                    <h3><?php echo $file['username']; ?></h3>
                    <p>الدولة: <?php echo $file['country']; ?></p>
                    <p>نوع الجهاز: <?php echo $file['device_type']; ?></p>
                    <p>اسم الملف: <?php echo $file['file_name']; ?></p>
                    <p>تاريخ الرفع: <?php echo $file['created_at']; ?></p>
                    <p>تاريخ انتهاء الصلاحية: <?php echo $file['expires_at']; ?></p>
                    <a href="download_file.php?code=<?php echo $file['download_code']; ?>" class="btn btn-primary">تحميل الملف</a>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "<script>alert('الرابط غير صالح أو انتهت صلاحيته.'); window.location.href='../index.php';</script>";
    }
} else {
    echo "<script>alert('الرابط غير صحيح.'); window.location.href='../index.php';</script>";
}
?>