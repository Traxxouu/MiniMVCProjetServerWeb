<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Efrei Tech' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <nav>
        <div class="nav-header">
            <img src="/assets/images/logo-efrei-tech.png" alt="Efrei Tech Logo" class="logo">
            <h1>EFREI TECH</h1>
        </div>
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="/produits">Produits</a></li>
            <li><a href="/panier">Panier</a></li>
            <?php if (isset($_SESSION['utilisateur_id'])): ?>
                <li>Bonjour <?= htmlspecialchars($_SESSION['utilisateur_nom']) ?></li>
                <li><a href="/historique">Mes commandes</a></li>
                <li><a href="/deconnexion">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/connexion">Connexion</a></li>
                <li><a href="/inscription">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <p>&copy; 2024 Efrei Tech - Tous droits réservés</p>
        <p><a href="https://maelbarbe.vercel.app" target="_blank">Mael Barbe B2 DEV</a></p>
    </footer>
</body>
</html>