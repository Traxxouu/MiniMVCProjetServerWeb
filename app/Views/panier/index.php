<h2>Mon panier</h2>

<?php if (isset($success) && $success === 'ajout'): ?>
    <div class="alert alert-success">
        Produit ajouté au panier !
    </div>
<?php endif; ?>

<?php if (isset($error) && $error === 'commande'): ?>
    <div class="alert alert-error">
        Une erreur est survenue lors de la validation de votre commande.
    </div>
<?php endif; ?>

<?php if (empty($articles)): ?>
    <div class="alert alert-warning">
        <p>Votre panier est vide.</p>
    </div>
    <a href="/produits" class="btn btn-primary">Continuer mes achats</a>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['nom']) ?></td>
                    <td><?= number_format($article['prix'], 2) ?> €</td>
                    <td>
                        <form method="POST" action="/panier/modifier" style="display: inline;">
                            <input type="hidden" name="panier_id" value="<?= $article['id'] ?>">
                            <input type="number" name="quantite" value="<?= $article['quantite'] ?>" min="1">
                            <button type="submit" class="btn btn-secondary" style="padding: 0.3rem 0.8rem;">
                                Modifier
                            </button>
                        </form>
                    </td>
                    <td><?= number_format($article['prix'] * $article['quantite'], 2) ?> €</td>
                    <td>
                        <a href="/panier/supprimer?id=<?= $article['id'] ?>" 
                           class="btn btn-danger" 
                           style="padding: 0.3rem 0.8rem;"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="cart-total">
        <h3>Total : <?= number_format($total, 2) ?> €</h3>
    </div>

    <div class="cart-actions">
        <a href="/produits" class="btn btn-secondary">Continuer mes achats</a>
        
        <?php if (isset($_SESSION['utilisateur_id'])): ?>
            <a href="/commande/valider" class="btn btn-success">Valider ma commande</a>
        <?php else: ?>
            <div class="alert alert-warning" style="flex: 1;">
                Vous devez vous <a href="/connexion">connecter</a> pour passer commande.
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>