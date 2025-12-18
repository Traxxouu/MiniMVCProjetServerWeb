<a href="/produits" class="back-link">← Retour aux produits</a>

<h2><?= htmlspecialchars($produit['nom']) ?></h2>

<div class="product-detail">
    <div class="product-detail-image">
        <img src="/assets/images/<?= htmlspecialchars($produit['image_url']) ?>" 
             alt="<?= htmlspecialchars($produit['nom']) ?>"
             onerror="this.src='/assets/images/placeholder.jpg'">
    </div>
    
    <div class="product-detail-info">
        <p><strong>Catégorie:</strong> <?= htmlspecialchars($produit['categorie_nom']) ?></p>
        <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($produit['description'])) ?></p>
        <p><strong>Prix:</strong> <span class="product-price"><?= number_format($produit['prix'], 2) ?> €</span></p>
        <p><strong>Stock disponible:</strong> <?= $produit['stock'] ?> unités</p>
        
        <?php if ($produit['stock'] > 0): ?>
            <form method="POST" action="/panier/ajouter">
                <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                <div class="form-group">
                    <label for="quantite">Quantité:</label>
                    <input type="number" name="quantite" id="quantite" value="1" min="1" max="<?= $produit['stock'] ?>">
                </div>
                <button type="submit" class="btn btn-success">Ajouter au panier</button>
            </form>
        <?php else: ?>
            <div class="alert alert-error">
                <strong>Produit en rupture de stock</strong>
            </div>
        <?php endif; ?>
    </div>
</div>