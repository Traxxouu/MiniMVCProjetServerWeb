<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Core\Database;
use Mini\Models\Commande;
use Mini\Models\Panier;
use Mini\Models\Produit;

final class CommandeController extends Controller
{
    // Valide la commande
    public function valider(): void
    {
        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['utilisateur_id'])) {
            header('Location: /connexion');
            exit;
        }
        
        $utilisateur_id = $_SESSION['utilisateur_id'];
        $session_id = session_id();
        
        // Récupère les articles du panier
        $articles = Panier::getArticles($utilisateur_id, $session_id);
        
        if (empty($articles)) {
            header('Location: /panier');
            exit;
        }
        
        // Calcul du total
        $total = 0;
        foreach ($articles as $article) {
            $total += $article['prix'] * $article['quantite'];
        }
        
        $pdo = Database::getPDO();
        
        try {
            $pdo->beginTransaction();
            
            // Crée la commande
            $commande_id = Commande::creer($utilisateur_id, $total);
            
            // Ajoute les lignes de commande et réduit le stock
            foreach ($articles as $article) {
                Commande::ajouterLigne(
                    $commande_id,
                    $article['produit_id'],
                    $article['quantite'],
                    $article['prix']
                );
                Produit::reduireStock($article['produit_id'], $article['quantite']);
            }
            
            // Vide le panier
            Panier::vider($utilisateur_id, $session_id);
            
            $pdo->commit();
            
            header('Location: /commande/confirmation?id=' . $commande_id);
            exit;
            
        } catch (\Exception $e) {
            $pdo->rollBack();
            header('Location: /panier?error=commande');
            exit;
        }
    }

    // Affiche la confirmation de commande
    public function confirmation(): void
    {
        if (!isset($_SESSION['utilisateur_id'])) {
            header('Location: /connexion');
            exit;
        }
        
        $commande_id = $_GET['id'] ?? null;
        
        if (!$commande_id) {
            header('Location: /');
            exit;
        }
        
        $commande = Commande::findById((int)$commande_id);
        
        // Vérifie que la commande appartient à l'utilisateur
        if (!$commande || $commande['utilisateur_id'] != $_SESSION['utilisateur_id']) {
            header('Location: /');
            exit;
        }
        
        $lignes = Commande::getLignes((int)$commande_id);
        
        $this->render('commande/confirmation', params: [
            'title' => 'Commande confirmée - Efrei Tech',
            'commande' => $commande,
            'lignes' => $lignes
        ]);
    }

    // Affiche l'historique des commandes
    public function historique(): void
    {
        if (!isset($_SESSION['utilisateur_id'])) {
            header('Location: /connexion');
            exit;
        }
        
        $commandes = Commande::getByUtilisateur($_SESSION['utilisateur_id']);
        
        $this->render('commande/historique', params: [
            'title' => 'Mes commandes - Efrei Tech',
            'commandes' => $commandes
        ]);
    }

    // Affiche le détail d'une commande
    public function detail(): void
    {
        if (!isset($_SESSION['utilisateur_id'])) {
            header('Location: /connexion');
            exit;
        }
        
        $commande_id = $_GET['id'] ?? null;
        
        if (!$commande_id) {
            header('Location: /historique');
            exit;
        }
        
        $commande = Commande::findById((int)$commande_id);
        
        if (!$commande || $commande['utilisateur_id'] != $_SESSION['utilisateur_id']) {
            header('Location: /historique');
            exit;
        }
        
        $lignes = Commande::getLignes((int)$commande_id);
        
        $this->render('commande/detail', params: [
            'title' => 'Commande #' . $commande_id . ' - Efrei Tech',
            'commande' => $commande,
            'lignes' => $lignes
        ]);
    }
}