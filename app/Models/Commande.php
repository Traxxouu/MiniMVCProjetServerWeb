<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Commande
{
    private $id;
    private $utilisateur_id;
    private $montant_total;
    private $statut;

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getUtilisateurId() { return $this->utilisateur_id; }
    public function setUtilisateurId($utilisateur_id) { $this->utilisateur_id = $utilisateur_id; }
    public function getMontantTotal() { return $this->montant_total; }
    public function setMontantTotal($montant_total) { $this->montant_total = $montant_total; }
    public function getStatut() { return $this->statut; }
    public function setStatut($statut) { $this->statut = $statut; }

    // Crée une nouvelle commande et retourne son ID
    public static function creer($utilisateur_id, $montant_total)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO commandes (utilisateur_id, montant_total, statut) VALUES (?, ?, 'en_attente')");
        $stmt->execute([$utilisateur_id, $montant_total]);
        return $pdo->lastInsertId();
    }

    // Ajoute une ligne de commande
    public static function ajouterLigne($commande_id, $produit_id, $quantite, $prix_unitaire)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO lignes_commande (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$commande_id, $produit_id, $quantite, $prix_unitaire]);
    }

    // Récupère les commandes d'un utilisateur
    public static function getByUtilisateur($utilisateur_id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM commandes WHERE utilisateur_id = ? ORDER BY date_creation DESC");
        $stmt->execute([$utilisateur_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère une commande par ID
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère les lignes d'une commande
    public static function getLignes($commande_id)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT lc.*, p.nom, p.image_url 
                FROM lignes_commande lc 
                JOIN produits p ON lc.produit_id = p.id 
                WHERE lc.commande_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$commande_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}