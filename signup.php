<?php
// signup.php

session_start();

// إعدادات قاعدة البيانات
$host = "192.168.0.100";
$dbname = "adoptidz_online";   // غيّرها إذا سميت قاعدة البيانات باسم آخر
$username = "adoptidz_online";  // غيّرها إذا كان عندك مستخدم مختلف
$password = "zK6Ev8ev8D9Ms5WTHm8N";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

// التحقق من أن الفورم أُرسل
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // التحقق من الحقول
    if (empty($fullname) || empty($email) || empty($pass) || empty($confirm)) {
        die("⚠️ Tous les champs sont obligatoires.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("⚠️ Email invalide.");
    }

    if ($pass !== $confirm) {
        die("⚠️ Les mots de passe ne correspondent pas.");
    }

    // التحقق إذا كان الإيميل موجود من قبل
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die("⚠️ Cet email est déjà utilisé.");
    }

    // تشفير الباسوورد
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    // إدخال المستخدم في قاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$fullname, $email, $hashedPassword])) {
        // تسجيل الدخول مباشرة بعد التسجيل
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['fullname'] = $fullname;

        // توجيه المستخدم نحو لوحة التحكم
        header("Location: dashboard.php");
        exit;
    } else {
        die("⚠️ Une erreur est survenue lors de l'inscription.");
    }
}
?>
