<?php
// logout.php
session_start();

// تدمير كل بيانات السيشن
session_unset();
session_destroy();

// رجع المستخدم لصفحة تسجيل الدخول
header("Location: login.html");
exit;
?>
