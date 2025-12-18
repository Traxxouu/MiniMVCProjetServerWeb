<?php

declare(strict_types=1);

// Démarre la session
session_start();

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;

// Table des routes
$routes = [
    // Accueil
    ['GET', '/', [Mini\Controllers\AccueilController::class, 'index']],
    
    // Produits
    ['GET', '/produits', [Mini\Controllers\ProduitController::class, 'liste']],
    ['GET', '/produit', [Mini\Controllers\ProduitController::class, 'detail']],
    
    // Authentification
    ['GET', '/inscription', [Mini\Controllers\AuthController::class, 'inscription']],
    ['POST', '/inscription', [Mini\Controllers\AuthController::class, 'inscription']],
    ['GET', '/connexion', [Mini\Controllers\AuthController::class, 'connexion']],
    ['POST', '/connexion', [Mini\Controllers\AuthController::class, 'connexion']],
    ['GET', '/deconnexion', [Mini\Controllers\AuthController::class, 'deconnexion']],
    
    // Panier
    ['GET', '/panier', [Mini\Controllers\PanierController::class, 'afficher']],
    ['POST', '/panier/ajouter', [Mini\Controllers\PanierController::class, 'ajouter']],
    ['GET', '/panier/supprimer', [Mini\Controllers\PanierController::class, 'supprimer']],
    ['POST', '/panier/modifier', [Mini\Controllers\PanierController::class, 'modifier']],
    
    // Commandes
    ['GET', '/commande/valider', [Mini\Controllers\CommandeController::class, 'valider']],
    ['GET', '/commande/confirmation', [Mini\Controllers\CommandeController::class, 'confirmation']],
    ['GET', '/historique', [Mini\Controllers\CommandeController::class, 'historique']],
    ['GET', '/commande/detail', [Mini\Controllers\CommandeController::class, 'detail']],
];

// Bootstrap du router
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);