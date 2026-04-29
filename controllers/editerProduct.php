<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit();
}

require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../models/ProductManager.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/FileUploader.php';

$pm = new ProductManager($db);


$code = isset($_GET['id']) ? $_GET['id'] : null;

if (!$code) {
    die("ID invalide");
}


$product = $pm->getProduct($code);

if (!$product) {
    die("Produit introuvable");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $image = $product->getImage();

    if (!empty($_FILES["image_file"]["name"])) {
        $uploader = new FileUploader();
        $uploadResult = $uploader->upload($_FILES["image_file"]);
        
        if ($uploadResult !== false) {
            $image = $uploadResult;
        } else {
            $error = "Erreur image: " . implode(" | ", $uploader->getErrors());
            // Optionally we can stop execution or just continue with the old image
            // Since we set $error, we can just skip updating or break
        }
    }

    $updatedProduct = new Product(
        $code,
        $_POST["name"],
        $_POST["price"],
        $_POST["category"],
        $_POST["stock"],
        $image,
        isset($_POST["on_sale"]),
        $_POST["old_price"] === '' ? null : $_POST["old_price"]
    );

    if ($pm->update($updatedProduct)) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['success'] = "Modification effectuée avec succès !";
        header("Location: ../controllers/productController.php");
        exit();
    } else {
        $error = "Erreur lors de la mise à jour";
    }
}


require __DIR__ . '/../views/editProduct.php';