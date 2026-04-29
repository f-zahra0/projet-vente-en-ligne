<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - E-Shop Manager</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header class="header">
        <a href="dashboard.php" class="header-brand">E-Shop Manager</a>
        <nav class="header-nav">
            <a href="dashboard.php" class="btn btn-secondary" style="border: none; background: transparent;">Accueil</a>
            <a href="../controllers/productController.php" class="btn btn-secondary" style="border: none; background: transparent;">Catalogue</a>
            <a href="addProduct.php" class="btn btn-primary">➕ Ajouter Produit</a>
            <a href="../controllers/AuthController.php?logout=1" class="btn btn-secondary">Déconnexion</a>
        </nav>
    </header>

    <main class="container">
        <div style="text-align: center; margin-top: 3rem;">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Bienvenue, <?= htmlspecialchars($_SESSION["user"]) ?> !</h1>
            <p style="color: var(--text-light); margin-bottom: 3rem; font-size: 1.1rem;">
                Gérez votre boutique en toute simplicité.
            </p>

            <div style="display: flex; justify-content: center; gap: 2rem;">
                <a href="../controllers/productController.php" class="product-card" style="width: 300px; text-decoration: none; text-align: center; padding: 3rem 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                    <h3 class="product-title">Catalogue Produits</h3>
                    <p style="color: var(--text-light); margin-top: 0.5rem;">Gérer les produits de votre boutique</p>
                </a>

                <a href="addProduct.php" class="product-card" style="width: 300px; text-decoration: none; text-align: center; padding: 3rem 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">➕</div>
                    <h3 class="product-title">Nouveau Produit</h3>
                    <p style="color: var(--text-light); margin-top: 0.5rem;">Ajouter un produit au catalogue</p>
                </a>
            </div>
        </div>
    </main>

</body>
</html>