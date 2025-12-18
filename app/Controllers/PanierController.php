<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Panier;

final class PanierController extends Controller
{
    // Affiche le panier
    public function afficher(): void
    {
        $utilisateur_id = $_SESSION['utilisateur_id'] ?? null;
        $session_id = session_id();
        
        $articles = Panier::getArticles($utilisateur_id, $session_id);
        
        // Calcul du total
        $total = 0;
        foreach ($articles as $article) {
            $total += $article['prix'] * $article['quantite'];
        }
        
        $success = $_GET['success'] ?? null;
        $error = $_GET['error'] ?? null;
        
        $this->render('panier/index', params: [
            'title' => 'Panier - Efrei Tech',
            'articles' => $articles,
            'total' => $total,
            'success' => $success,
            'error' => $error
        ]);
    }

    // Ajoute un produit au panier
    public function ajouter(): void
    {
        $produit_id = $_POST['produit_id'] ?? null;
        $quantite = (int)($_POST['quantite'] ?? 1);
        
        if ($produit_id) {
            $utilisateur_id = $_SESSION['utilisateur_id'] ?? null;
            $session_id = session_id();
            
            Panier::ajouter($utilisateur_id, $session_id, (int)$produit_id, $quantite);
            
            header('Location: /panier?success=ajout');
            exit;
        }
        
        header('Location: /');
        exit;
    }

    // Supprime un article du panier
    public function supprimer(): void
    {
        $panier_id = $_GET['id'] ?? null;
        
        if ($panier_id) {
            Panier::supprimer((int)$panier_id);
        }
        
        header('Location: /panier');
        exit;
    }

    // MaJ la quantité
    public function modifier(): void
    {
        $panier_id = $_POST['panier_id'] ?? null;
        $quantite = (int)($_POST['quantite'] ?? 1);
        
        if ($panier_id && $quantite > 0) {
            Panier::mettreAJourQuantite((int)$panier_id, $quantite);
        }
        
        header('Location: /panier');
        exit;
    }
}