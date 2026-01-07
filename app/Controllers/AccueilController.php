<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Produit;
use Mini\Models\Categorie;

final class AccueilController extends Controller
{
    public function index(): void
    {
        // Récupère tous les produit et catégories
        $produit = Produit::getAll();
        $categories = Categorie::getAll();
        
        $this->render('accueil/index', params: [
            'title' => 'Efrei Tech - Accueil',
            'produit' => $produit,
            'categories' => $categories
        ]);
    }
}