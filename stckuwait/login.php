<?php
session_start();

$correct_username = "admin";
$correct_password = "Fayiz@@20"; // يفضل تغييره لاحقًا

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "اسم المستخدم أو كلمة المرور خاطئة!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 40px; background: #f9f9f9; }
        form { display: inline-block; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        input { display: block; margin: 10px auto; padding: 10px; width: 200px; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>تسجيل الدخول إلى لوحة التحكم</h2>

<?php if (isset($error)): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit">دخول</button>
</form>

</body>
</html>
