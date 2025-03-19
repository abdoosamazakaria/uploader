<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'];

    // تحديث البيانات
    $stmt = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $stmt->execute([$bio, $_SESSION['user_id']]);

    // رفع صورة الملف الشخصي
    if (!empty($_FILES['profile_picture']['name'])) {
        $file = $_FILES['profile_picture'];
        $fileName = basename($file['name']);
        $fileTmpName = $file['tmp_name'];
        $fileDestination = '../uploads/profile_pictures/' . $fileName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->execute([$fileDestination, $_SESSION['user_id']]);
        }
    }

    redirect('profile.php');
}

// جلب بيانات المستخدم
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
        <h1 class="text-center">الملف الشخصي</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?php echo $user['profile_picture'] ?? 'https://via.placeholder.com/150'; ?>" class="img-fluid rounded-circle" alt="صورة الملف الشخصي">
                        <h5 class="card-title mt-3"><?php echo $user['username']; ?></h5>
                        <p class="card-text">الدولة: <?php echo $user['country']; ?></p>
                        <p class="card-text">نوع الجهاز: <?php echo $user['device_type']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="profile.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">صورة الملف الشخصي</label>
                                <input type="file" name="profile_picture" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">السيرة الذاتية</label>
                                <textarea name="bio" class="form-control"><?php echo $user['bio'] ?? ''; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>