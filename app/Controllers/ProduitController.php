<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Produit;
use Mini\Models\Categorie;

final class ProduitController extends Controller
{
    // Affiche la liste des produits
    public function liste(): void
    {
        $categorie_id = $_GET['categorie'] ?? null;
        
        if ($categorie_id) {
            $produits = Produit::getByCategorie((int)$categorie_id);
        } else {
            $produits = Produit::getAll();
        }
        
        $categories = Categorie::getAll();
        
        $this->render('produit/liste', params: [
            'title' => 'Produits - Efrei Tech',
            'produits' => $produits,
            'categories' => $categories
        ]);
    }

    // Affiche le détail d'un produit
    public function detail(): void
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /produits');
            exit;
        }
        
        $produit = Produit::findById((int)$id);
        
        if (!$produit) {
            header('Location: /produits');
            exit;
        }
        
        $this->render('produit/detail', params: [
            'title' => $produit['nom'] . ' - Efrei Tech',
            'produit' => $produit
        ]);
    }
}