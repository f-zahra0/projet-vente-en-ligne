<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit();
}

require_once "../config/db_connect.php";
require_once "../models/ProductManager.php";
require_once "../models/Product.php";

$pm = new ProductManager($db);

$action = $_GET['action'] ?? 'list';

if ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $pm->delete($id);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['success'] = "Le produit a été supprimé avec succès.";
    }
    header("Location: productController.php");
    exit();
}

if ($action === 'search') {

    $name = $_GET['name'] ?? '';
    $category = $_GET['category'] ?? '';

    $products = $pm->search($name, $category);

    require "../views/catalogue.php";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $code = $_POST['code'];

  
    if ($pm->getProduct($code)) {
        die("Produit déjà existe !");
    }

    $product = new Product(
        $code,
        $_POST['name'],
        $_POST['price'],
        $_POST['category'],
        $_POST['stock']
    );

    $pm->insert($product);

    header("Location: ../views/catalogue.php");
    exit();
}


$products = $pm->getAllProducts();

require "../views/catalogue.php";