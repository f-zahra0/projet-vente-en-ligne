<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit();
}

require_once "../config/db_connect.php";
require_once "../models/Product.php";
require_once "../models/ProductManager.php";
require_once "../models/FileUploader.php";

$message = "";

$pm = new ProductManager($db);

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $code = $_POST["code"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $category = $_POST["category"];

    /* -------- Upload image -------- */

    $image = "product.jpg";

    if(!empty($_FILES["image_file"]["name"])){
        $uploader = new FileUploader();
        $uploadResult = $uploader->upload($_FILES["image_file"]);
        
        if ($uploadResult !== false) {
            $image = $uploadResult;
        } else {
            session_start();
            $_SESSION['error'] = "Erreur image: " . implode(" | ", $uploader->getErrors());
            header("Location: ../views/addProduct.php");
            exit();
        }
    }

    /* -------- Création objet Product -------- */

    $product = new Product(
        $code,
        $name,
        $price,
        $category,
        $stock,
        $image,
        false,
        null
    );

    /* -------- insertion -------- */

    try {
        if($pm->insert($product)){
            header("Location: ../controllers/productController.php");
            exit();
        }else{
            session_start();
            $_SESSION['error'] = "Erreur lors de l'ajout.";
            header("Location: ../views/addProduct.php");
            exit();
        }
    } catch (PDOException $e) {
        session_start();
        if ($e->getCode() == 23000) {
            $_SESSION['error'] = "Le produit avec le code '" . htmlspecialchars($code) . "' existe déjà ! Veuillez en choisir un autre.";
        } else {
            $_SESSION['error'] = "Erreur base de données : " . $e->getMessage();
        }
        header("Location: ../views/addProduct.php");
        exit();
    }

}
