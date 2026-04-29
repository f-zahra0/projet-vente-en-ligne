<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit - E-Shop Manager</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="header">
        <a href="../views/dashboard.php" class="header-brand">E-Shop Manager</a>
        <nav class="header-nav">
            <a href="../views/dashboard.php" class="btn btn-secondary" style="border: none; background: transparent;">Accueil</a>
            <a href="../controllers/productController.php" class="btn btn-secondary" style="border: none; background: transparent;">Catalogue</a>
            <a href="../views/addProduct.php" class="btn btn-primary">➕ Ajouter Produit</a>
            <a href="../controllers/AuthController.php?logout=1" class="btn btn-secondary">Déconnexion</a>
        </nav>
    </header>

    <main class="container">
        <div class="form-container">
            <h2 class="form-title">Modifier Produit</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Code Produit</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($product->getCode()) ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label">Nom du produit</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product->getName()) ?>" required>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Prix actuel (DT)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?= $product->getPrice() ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Ancien Prix (DT)</label>
                        <input type="number" step="0.01" name="old_price" class="form-control" value="<?= $product->getOldPrice() ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Catégorie</label>
                        <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($product->getCategory()) ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="<?= $product->getStock() ?>" required>
                    </div>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="on_sale" id="on_sale" <?= $product->getOnSale() ? 'checked' : '' ?>>
                    <label class="form-label" for="on_sale" style="margin-bottom: 0;">En Promotion</label>
                </div>

                <div class="form-group">
                    <label class="form-label">Nouvelle image (optionnelle)</label>
                    <input type="file" name="image_file" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Image actuelle</label>
                    <div class="product-image-container" style="border-radius: 8px; width: 120px; height: 120px;">
                        <img src="../publicuploadsproducts/<?= htmlspecialchars(basename($product->getImage())) ?>" class="product-image" onerror="this.src='../publicuploadsproducts/product.jpg'">
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-success btn-block">Enregistrer les modifications</button>
                    <a href="../controllers/productController.php" class="btn btn-secondary btn-block" style="margin-top: 1rem;">Annuler et retourner</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>