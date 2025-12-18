<h2>Historique de mes commandes</h2>

<?php if (empty($commandes)): ?>
    <div class="alert alert-warning">
        <p>Vous n'avez pas encore passé de commande.</p>
    </div>
    <a href="/produits" class="btn btn-primary">Découvrir nos produits</a>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>N° Commande</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $cmd): ?>
                <tr>
                    <td>#<?= $cmd['id'] ?></td>
                    <td><?= date('d/m/Y', strtotime($cmd['date_creation'])) ?></td>
                    <td><?= number_format($cmd['montant_total'], 2) ?> €</td>
                    <td>
                        <span class="status-badge status-<?= $cmd['statut'] ?>">
                            <?php 
                                $statuts = [
                                    'en_attente' => 'En attente',
                                    'confirmee' => 'Confirmée',
                                    'expediee' => 'Expédiée',
                                    'livree' => 'Livrée',
                                    'annulee' => 'Annulée'
                                ];
                                echo $statuts[$cmd['statut']] ?? $cmd['statut'];
                            ?>
                        </span>
                    </td>
                    <td>
                        <a href="/commande/detail?id=<?= $cmd['id'] ?>" class="btn btn-primary" style="padding: 0.4rem 0.8rem;">
                            Voir le détail
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>