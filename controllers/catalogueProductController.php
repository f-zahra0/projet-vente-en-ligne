<?php
        require "../config/db_connect.php";  
        require "../models/product.php";
        require "../models/productManager.php";

        $manager= new ProductManager($db);
        $products=$manager->getAllProducts();
?>