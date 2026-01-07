<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Produit;
use Mini\Models\Categorie;

final class ProduitController extends Controller
{
    // Affiche la liste des produit
    public function liste(): void
    {
        $categorie_id = $_GET['categorie'] ?? null;
        
        if ($categorie_id) {
            $produit = Produit::getByCategorie((int)$categorie_id);
        } else {
            $produit = Produit::getAll();
        }
        
        $categories = Categorie::getAll();
        
        $this->render('produit/liste', params: [
            'title' => 'produit - Efrei Tech',
            'produit' => $produit,
            'categories' => $categories
        ]);
    }

    // Affiche le détail d'un produit
    public function detail(): void
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /produit');
            exit;
        }
        
        $produit = Produit::findById((int)$id);
        
        if (!$produit) {
            header('Location: /produit');
            exit;
        }
        
        $this->render('produit/detail', params: [
            'title' => $produit['nom'] . ' - Efrei Tech',
            'produit' => $produit
        ]);
    }
}