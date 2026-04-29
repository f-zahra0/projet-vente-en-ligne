<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit();
}
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue Produits - E-Shop Manager</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header class="header">
        <a href="../views/dashboard.php" class="header-brand">E-Shop Manager</a>
        <nav class="header-nav">
            <a href="../views/dashboard.php" class="btn btn-secondary" style="border: none; background: transparent;">Accueil</a>
            <a href="../controllers/productController.php" class="btn btn-secondary" style="border: none; background: transparent;">Catalogue</a>
            <a href="../views/addProduct.php" class="btn btn-primary"> Ajouter Produit</a>
            <a href="../controllers/AuthController.php?logout=1" class="btn btn-secondary">Déconnexion</a>
        </nav>
    </header>

    <main class="container">
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="GET" action="../controllers/productController.php" class="search-bar">
            <input type="hidden" name="action" value="search">
            <div class="form-group search-input">
                <label class="form-label">Nom du produit</label>
                <input type="text" name="name" class="form-control" placeholder="Rechercher...">
            </div>
            <div class="form-group search-input">
                <label class="form-label">Catégorie</label>
                <input type="text" name="category" class="form-control" placeholder="Toutes les catégories">
            </div>
            <button type="submit" class="btn btn-secondary"> Rechercher</button>
        </form>

        <?php if (!empty($products) && is_array($products)): ?>
            <div class="product-grid">
                <?php foreach ($products as $p): ?>
                    <div class="product-card">
                        <?php 
                            $isPromo = $p->getOnSale() || ($p->getOldPrice() > 0 && $p->getPrice() < $p->getOldPrice());
                        ?>
                        <?php if ($isPromo): ?>
                            <span class="product-badge">Promo</span>
                        <?php endif; ?>
                        
                        <div class="product-image-container">
                            <img src="../publicuploadsproducts/<?= htmlspecialchars(basename($p->getImage())) ?>" class="product-image" onerror="this.src='../publicuploadsproducts/product.jpg'" alt="<?= htmlspecialchars($p->getName()) ?>">
                        </div>
                        
                        <div class="product-info">
                            <div class="product-category"><?= htmlspecialchars($p->getCategory()) ?></div>
                            <h3 class="product-title"><?= htmlspecialchars($p->getName()) ?></h3>
                            
                            <div class="product-price-wrapper" style="margin-bottom: <?= $isPromo ? '0.25rem' : '1rem' ?>;">
                                <span class="product-price"><?= number_format($p->getPrice(), 2) ?> DT</span>
                                <?php if ($p->getOldPrice() > 0): ?>
                                    <span class="product-old-price"><?= number_format($p->getOldPrice(), 2) ?> DT</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($p->getOldPrice() > 0 && $p->getPrice() < $p->getOldPrice()): ?>
                                <div style="color: var(--danger-color); font-size: 0.85rem; font-weight: 700; margin-bottom: 1rem;">
                                     PROMO SPÉCIALE
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-stock <?= $p->getStock() < 5 ? 'low-stock' : '' ?>">
                                <?= $p->getStock() > 0 ? "En stock: {$p->getStock()}" : "Rupture de stock" ?>
                            </div>
                            
                            <div class="product-actions">
                                <a href="../controllers/editerProduct.php?id=<?= urlencode($p->getCode()) ?>" class="btn btn-secondary btn-sm" style="flex: 1; text-align: center;">Modifier</a>
                                <a href="../controllers/productController.php?action=delete&id=<?= urlencode($p->getCode()) ?>" class="btn btn-danger btn-sm" style="flex: 1; text-align: center;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-danger" style="margin-top: 2rem; justify-content: center;">
                Aucun produit trouvé dans le catalogue.
            </div>
        <?php endif; ?>

    </main>

</body>
</html>