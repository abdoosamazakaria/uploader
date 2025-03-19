<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isAdminLoggedIn()) {
    redirect('admin_login.php');
}

$stmt = $pdo->query("SELECT files.*, users.username FROM files LEFT JOIN users ON files.user_id = users.id");
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المشرف</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">لوحة تحكم المشرف</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>اسم الملف</th>
                        <th>المستخدم</th>
                        <th>تاريخ الرفع</th>
                        <th>تاريخ الانتهاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td><?php echo $file['file_name']; ?></td>
                            <td><?php echo $file['username'] ?? 'مجهول'; ?></td>
                            <td><?php echo $file['created_at']; ?></td>
                            <td><?php echo $file['expires_at']; ?></td>
                            <td>
                                <a href="download.php?code=<?php echo $file['download_code']; ?>" class="btn btn-primary">تحميل</a>
                                <a href="delete_file.php?id=<?php echo $file['id']; ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>