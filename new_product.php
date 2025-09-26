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
 * 🟢 جلب جميع المنتجات (Market)
 */
if (isset($_GET['action']) && $_GET['action'] === "all") {
    $stmt = $pdo->query("SELECT * FROM produit ORDER BY id DESC");
    $products = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['images'] = $row['images'] ? json_decode($row['images'], true) : [];
        $row['is_owner'] = (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']);
        $products[] = $row;
    }
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($products);
    exit;
}

/**
 * 🟢 تعديل منتج (فقط المالك يقدر)
 */
if (isset($_GET['action']) && $_GET['action'] === "update" && $_SERVER['REQUEST_METHOD'] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "Vous devez vous connecter"]);
        exit;
    }

    $id = intval($_POST['id']);
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $wilaya = trim($_POST['wilaya'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $item_condition = trim($_POST['item_condition'] ?? '');
    $user_id = $_SESSION['user_id'];

    // التحقق من ملكية المنتج
    $stmt = $pdo->prepare("SELECT user_id, images FROM produit WHERE id=?");
    $stmt->execute([$id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prod) {
        echo json_encode(["status" => "error", "message" => "Produit introuvable"]);
        exit;
    }
    if ($prod['user_id'] != $user_id) {
        echo json_encode(["status" => "error", "message" => "Non autorisé"]);
        exit;
    }

    // معالجة الصور (احتفاظ بالقديمة + إضافة الجديدة)
    $existing = $prod['images'] ? json_decode($prod['images'], true) : [];
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
    $stmt = $pdo->prepare("UPDATE produit 
        SET title=?, description=?, price=?, category=?, item_condition=?, wilaya=?, phone=?, images=? 
        WHERE id=?");
    if ($stmt->execute([$title, $description, $price, $category, $item_condition, $wilaya, $phone, $images_json, $id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erreur update"]);
    }
    exit;
}

/**
 * 🟢 إضافة منتج جديد
 */
if ($_SERVER['REQUEST_METHOD'] === "POST" && !isset($_GET['action'])) {
    if (!isset($_SESSION['user_id'])) {
        die("⚠️ Vous devez vous connecter avant de publier un produit.");
    }

    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $item_condition = trim($_POST['item_condition'] ?? '');
    $wilaya = trim($_POST['wilaya'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $description = trim($_POST['description'] ?? '');

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

    // إدخال المنتج
    $stmt = $pdo->prepare("INSERT INTO produit 
        (user_id, title, category, price, item_condition, wilaya, phone, description, images) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $category, $price, $item_condition, $wilaya, $phone, $description, $images_json]);

    header("Location: market.php");
    exit;
}

echo "❌ Requête invalide";
