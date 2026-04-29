<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - E-Shop Manager</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
    </style>
</head>
<body>

    <div class="form-container" style="width: 100%; max-width: 400px; margin: 0;">
        <h2 class="form-title" style="color: var(--primary-color);">E-Shop Manager</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="../controllers/AuthController.php">
            <div class="form-group">
                <label class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" placeholder="Entrez votre nom d'utilisateur" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary btn-block" style="margin-top: 1.5rem;">
                Se connecter
            </button>
        </form>
    </div>

</body>
</html>