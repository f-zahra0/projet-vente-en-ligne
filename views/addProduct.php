<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit - E-Shop Manager</title>
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
        <div class="form-container">
            <h2 class="form-title">Nouveau Produit</h2>
            
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="../controllers/addProductController.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="code">Code Produit (identifiant)</label>
                    <input type="text" name="code" id="code" class="form-control" placeholder="ex: P001" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Désignation</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nom du produit" required>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="price">Prix (DT)</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="stock">Quantité en stock</label>
                        <input type="number" name="stock" id="stock" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">Catégorie</label>
                    <input type="text" name="category" id="category" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="image_file">Image du produit</label>
                    <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
                    <small class="text-light" style="display: block; margin-top: 0.5rem; font-size: 0.85rem;">
                        Extensions autorisées : JPG, PNG, GIF (Max 2 Mo)
                    </small>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary btn-block">
                        Confirmer l'ajout
                    </button>
                    <a href="../controllers/productController.php" class="btn btn-secondary btn-block" style="margin-top: 1rem;">
                        Retour au catalogue
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>