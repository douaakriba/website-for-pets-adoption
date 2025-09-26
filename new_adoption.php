<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// إعدادات قاعدة البيانات
$host = "192.168.0.100";
$dbname = "adoptidz_online";
$dbuser = "adoptidz_online";
$dbpass = "zK6Ev8ev8D9Ms5WTHm8N";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion DB: " . $e->getMessage());
}

/**
 * 🟢 جلب جميع الإعلانات (للـ adoption.html)
 * يستعمل fetch("new_adoption.php?action=all")
 */
if (isset($_GET['action']) && $_GET['action'] === "all") {
    $stmt = $pdo->query("SELECT * FROM adoptions ORDER BY id DESC");
    $pets = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['images'] = $row['images'] ? json_decode($row['images'], true) : [];
        $row['is_owner'] = (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']);
        $pets[] = $row;
    }
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($pets);
    exit;
}

/**
 * 🟢 تعديل إعلان (فقط المالك)
 * يستعمل fetch("new_adoption.php?action=update", {method:"POST"})
 */
if (isset($_GET['action']) && $_GET['action'] === "update" && $_SERVER['REQUEST_METHOD'] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "Vous devez vous connecter"]);
        exit;
    }

    $id = intval($_POST['id']);
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $wilaya = trim($_POST['wilaya'] ?? '');
    $user_id = $_SESSION['user_id'];

    // تحقق أنو الإعلان موجود وصاحبو هو المالك
    $stmt = $pdo->prepare("SELECT user_id, images FROM adoptions WHERE id=?");
    $stmt->execute([$id]);
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ad) {
        echo json_encode(["status" => "error", "message" => "Annonce introuvable"]);
        exit;
    }
    if ($ad['user_id'] != $user_id) {
        echo json_encode(["status" => "error", "message" => "Non autorisé"]);
        exit;
    }

    // الصور: نحتفظ بالقديمة + نزيد الجديدة إذا كاين
    $existing = $ad['images'] ? json_decode($ad['images'], true) : [];
    $uploaded = $existing;
    if (!empty($_FILES['images']['name'][0])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        foreach ($_FILES['images']['name'] as $k => $name) {
            $tmp = $_FILES['images']['tmp_name'][$k];
            $newName = uniqid() . "_" . basename($name);
            $target = $upload_dir . $newName;
            if (move_uploaded_file($tmp, $target)) {
                $uploaded[] = $target;
            }
        }
    }
    $images_json = json_encode($uploaded);

    // التحديث
    $stmt = $pdo->prepare("UPDATE adoptions SET title=?, description=?, phone=?, wilaya=?, images=? WHERE id=?");
    if ($stmt->execute([$title, $description, $phone, $wilaya, $images_json, $id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erreur lors de la mise à jour"]);
    }
    exit;
}

/**
 * 🟢 إضافة إعلان جديد (من الفورم new_adoption.html)
 */
if ($_SERVER['REQUEST_METHOD'] === "POST" && !isset($_GET['action'])) {
    if (!isset($_SESSION['user_id'])) {
        die("⚠️ Vous devez vous connecter avant de publier une annonce.");
    }

    $title = trim($_POST['title'] ?? '');
    $species = trim($_POST['species'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $wilaya = trim($_POST['wilaya'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['user_id'];

    // معالجة الصور
    $uploaded = [];
    if (!empty($_FILES['images']['name'][0])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        foreach ($_FILES['images']['name'] as $k => $name) {
            $tmp = $_FILES['images']['tmp_name'][$k];
            $newName = uniqid() . "_" . basename($name);
            $target = $upload_dir . $newName;
            if (move_uploaded_file($tmp, $target)) {
                $uploaded[] = $target;
            }
        }
    }
    $images_json = json_encode($uploaded);

    // إدخال فقاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO adoptions (user_id, title, species, age, gender, wilaya, phone, description, images) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $title, $species, $age, $gender, $wilaya, $phone, $description, $images_json])) {
        header("Location: adoption.php");
        exit;
    } else {
        die("Erreur lors de l'insertion.");
    }
}

echo "❌ Requête invalide";






















