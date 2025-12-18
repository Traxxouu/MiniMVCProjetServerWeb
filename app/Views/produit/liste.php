<h2>Tous nos produits</h2>

<div class="products-layout">
    <aside class="categories-sidebar">
        <h3>Catégories</h3>
        <ul>
            <li><a href="/produits">Tous les produits</a></li>
            <?php foreach ($categories as $categorie): ?>
                <li>
                    <a href="/produits?categorie=<?= $categorie['id'] ?>">
                        <?= htmlspecialchars($categorie['nom']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    
    <section>
        <?php if (empty($produits)): ?>
            <div class="alert alert-warning">
                <p>Aucun produit disponible dans cette catégorie.</p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($produits as $produit): ?>
                    <a href="/produit?id=<?= $produit['id'] ?>" class="product-card-hover">
                        <div class="product-image">
                            <img src="/assets/images/<?= htmlspecialchars($produit['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($produit['nom']) ?>"
                                 onerror="this.src='/assets/images/placeholder.jpg'">
                            <div class="product-overlay">
                                <h4><?= htmlspecialchars($produit['nom']) ?></h4>
                                <p class="product-category"><em><?= htmlspecialchars($produit['categorie_nom']) ?></em></p>
                                <p class="product-description"><?= htmlspecialchars($produit['description']) ?></p>
                                <p class="product-price"><?= number_format($produit['prix'], 2) ?> €</p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>