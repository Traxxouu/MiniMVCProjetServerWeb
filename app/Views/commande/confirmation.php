<div class="alert alert-success" style="text-align: center; font-size: 1.2rem;">
    <h2>✓ Commande confirmée !</h2>
    <p>Merci pour votre commande. Votre numéro de commande est : <strong>#<?= $commande['id'] ?></strong></p>
</div>

<h3>Récapitulatif de votre commande</h3>

<div class="product-detail">
    <p><strong>Date :</strong> <?= date('d/m/Y à H:i', strtotime($commande['date_creation'])) ?></p>
    <p><strong>Statut :</strong> <span class="status-badge status-<?= $commande['statut'] ?>">
        <?= ucfirst(str_replace('_', ' ', $commande['statut'])) ?>
    </span></p>
    <p><strong>Montant total :</strong> <span class="product-price"><?= number_format($commande['montant_total'], 2) ?> €</span></p>
</div>

<h4>Articles commandés</h4>
<table>
    <thead>
        <tr>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lignes as $ligne): ?>
            <tr>
                <td><?= htmlspecialchars($ligne['nom']) ?></td>
                <td><?= number_format($ligne['prix_unitaire'], 2) ?> €</td>
                <td><?= $ligne['quantite'] ?></td>
                <td><?= number_format($ligne['prix_unitaire'] * $ligne['quantite'], 2) ?> €</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="cart-actions">
    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
    <a href="/historique" class="btn btn-secondary">Voir mes commandes</a>
</div>