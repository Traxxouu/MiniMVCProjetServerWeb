<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Panier
{
    private $id;
    private $utilisateur_id;
    private $session_id;
    private $produit_id;
    private $quantite;

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getUtilisateurId() { return $this->utilisateur_id; }
    public function setUtilisateurId($utilisateur_id) { $this->utilisateur_id = $utilisateur_id; }
    public function getSessionId() { return $this->session_id; }
    public function setSessionId($session_id) { $this->session_id = $session_id; }
    public function getProduitId() { return $this->produit_id; }
    public function setProduitId($produit_id) { $this->produit_id = $produit_id; }
    public function getQuantite() { return $this->quantite; }
    public function setQuantite($quantite) { $this->quantite = $quantite; }

    // Récupère les articles du panier
    public static function getArticles($utilisateur_id, $session_id)
    {
        $pdo = Database::getPDO();
        
        if ($utilisateur_id) {
            $sql = "SELECT pa.*, p.nom, p.prix, p.image_url 
                    FROM panier pa 
                    JOIN produits p ON pa.produit_id = p.id 
                    WHERE pa.utilisateur_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$utilisateur_id]);
        } else {
            $sql = "SELECT pa.*, p.nom, p.prix, p.image_url 
                    FROM panier pa 
                    JOIN produits p ON pa.produit_id = p.id 
                    WHERE pa.session_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$session_id]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajoute un produit au panier
    public static function ajouter($utilisateur_id, $session_id, $produit_id, $quantite = 1)
    {
        $pdo = Database::getPDO();
        
        // Vérifie si le produit existe déjà dans le panier
        if ($utilisateur_id) {
            $sql = "SELECT * FROM panier WHERE utilisateur_id = ? AND produit_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$utilisateur_id, $produit_id]);
        } else {
            $sql = "SELECT * FROM panier WHERE session_id = ? AND produit_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$session_id, $produit_id]);
        }
        
        $existant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existant) {
            // MaJ la quantité
            $nouvelleQuantite = $existant['quantite'] + $quantite;
            return self::mettreAJourQuantite($existant['id'], $nouvelleQuantite);
        } else {
            // Ajoute un nouvel article
            $sql = "INSERT INTO panier (utilisateur_id, session_id, produit_id, quantite) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$utilisateur_id, $session_id, $produit_id, $quantite]);
        }
    }

    // MaJ la quantité d'un article
    public static function mettreAJourQuantite($panier_id, $quantite)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE panier SET quantite = ? WHERE id = ?");
        return $stmt->execute([$quantite, $panier_id]);
    }

    // Supprime un article du panier
    public static function supprimer($panier_id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM panier WHERE id = ?");
        return $stmt->execute([$panier_id]);
    }

    // Vide le panier
    public static function vider($utilisateur_id, $session_id)
    {
        $pdo = Database::getPDO();
        
        if ($utilisateur_id) {
            $stmt = $pdo->prepare("DELETE FROM panier WHERE utilisateur_id = ?");
            return $stmt->execute([$utilisateur_id]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM panier WHERE session_id = ?");
            return $stmt->execute([$session_id]);
        }
    }
}