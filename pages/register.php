<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // الحصول على معلومات الدولة ونوع الجهاز
    $ip = $_SERVER['REMOTE_ADDR'];
    $country = getCountryFromIP($ip);
    $device_type = getDeviceType();

    // التحقق من وجود البريد الإلكتروني
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        echo "<script>alert('البريد الإلكتروني موجود مسبقًا.'); window.location.href='register.php';</script>";
    } else {
        // إدخال البيانات في قاعدة البيانات
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, country, device_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $country, $device_type]);
        redirect('login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل مستخدم جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">تسجيل مستخدم جديد</h1>
        <form action="register.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">اسم المستخدم</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">تسجيل</button>
        </form>
        <p class="text-center mt-3">لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a></p>
    </div>
</body>
</html>