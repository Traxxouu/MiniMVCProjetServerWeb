<div class="hero">
    <h2>Bienvenue sur Efrei Tech</h2>
    <p>Découvrez notre sélection de matériel informatique de qualité</p>
</div>

<section style="margin-bottom: 3rem;">
    <h3>Nos catégories</h3>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;">
        <?php foreach ($categories as $categorie): ?>
            <a href="/produits?categorie=<?= $categorie['id'] ?>" class="btn btn-secondary">
                <?= htmlspecialchars($categorie['nom']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section>
    <h3>Nos produits</h3>
    <div class="products-grid">
        <?php foreach ($produits as $produit): ?>
            <a href="/produit?id=<?= $produit['id'] ?>" class="product-card-hover">
                <div class="product-image">
                    <img src="/assets/images/<?= htmlspecialchars($produit['image_url']) ?>" 
                         alt="<?= htmlspecialchars($produit['nom']) ?>"
                         onerror="this.src='/assets/images/placeholder.jpg'">
                    <div class="product-overlay">
                        <h4><?= htmlspecialchars($produit['nom']) ?></h4>
                        <p class="product-description"><?= htmlspecialchars($produit['description']) ?></p>
                        <p class="product-price"><?= number_format($produit['prix'], 2) ?> €</p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>