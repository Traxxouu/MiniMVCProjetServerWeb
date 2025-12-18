<a href="/historique" class="back-link">← Retour à mes commandes</a>

<h2>Commande #<?= $commande['id'] ?></h2>

<div class="product-detail">
    <p><strong>Date de commande :</strong> <?= date('d/m/Y à H:i', strtotime($commande['date_creation'])) ?></p>
    <p><strong>Statut :</strong> 
        <span class="status-badge status-<?= $commande['statut'] ?>">
            <?php 
                $statuts = [
                    'en_attente' => 'En attente',
                    'confirmee' => 'Confirmée',
                    'expediee' => 'Expédiée',
                    'livree' => 'Livrée',
                    'annulee' => 'Annulée'
                ];
                echo $statuts[$commande['statut']] ?? $commande['statut'];
            ?>
        </span>
    </p>
    <p><strong>Montant total :</strong> <span class="product-price"><?= number_format($commande['montant_total'], 2) ?> €</span></p>
</div>

<h3>Articles commandés</h3>
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