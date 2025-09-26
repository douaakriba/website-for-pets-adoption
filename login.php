<?php
// login.php

session_start();

// إعدادات قاعدة البيانات
$host = "192.168.0.100";
$dbname = "adoptidz_online";   // نفس اسم قاعدة البيانات تاعك
$username = "adoptidz_online";  // غيّريه إذا عندك مستخدم مختلف
$password = "zK6Ev8ev8D9Ms5WTHm8N";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

// التحقق من أن الفورم أُرسل
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    if (empty($email) || empty($pass)) {
        die("⚠️ Email et mot de passe sont obligatoires.");
    }

    // جلب المستخدم من قاعدة البيانات
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        // ✅ تسجيل الدخول ناجح
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];

        header("Location: dashboard.php");
        exit;
    } else {
        die("⚠️ Email ou mot de passe incorrect.");
    }
}
?>
