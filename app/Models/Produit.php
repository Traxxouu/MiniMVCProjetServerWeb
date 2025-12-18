<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Produit
{
    private $id;
    private $categorie_id;
    private $nom;
    private $description;
    private $prix;
    private $stock;
    private $image_url;

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getCategorieId() { return $this->categorie_id; }
    public function setCategorieId($categorie_id) { $this->categorie_id = $categorie_id; }
    public function getNom() { return $this->nom; }
    public function setNom($nom) { $this->nom = $nom; }
    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }
    public function getPrix() { return $this->prix; }
    public function setPrix($prix) { $this->prix = $prix; }
    public function getStock() { return $this->stock; }
    public function setStock($stock) { $this->stock = $stock; }
    public function getImageUrl() { return $this->image_url; }
    public function setImageUrl($image_url) { $this->image_url = $image_url; }

    // Récupère tous les produits et leus categorie
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $sql = "SELECT p.*, c.nom as categorie_nom 
                FROM produits p 
                JOIN categories c ON p.categorie_id = c.id 
                ORDER BY p.date_creation DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un produit par ID
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT p.*, c.nom as categorie_nom 
                FROM produits p 
                JOIN categories c ON p.categorie_id = c.id 
                WHERE p.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère les produits par catégorie
    public static function getByCategorie($categorie_id)
    {
        $pdo = Database::getPDO();
        $sql = "SELECT p.*, c.nom as categorie_nom 
                FROM produits p 
                JOIN categories c ON p.categorie_id = c.id 
                WHERE p.categorie_id = ?
                ORDER BY p.date_creation DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$categorie_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function reduireStock($id, $quantite)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE produits SET stock = stock - ? WHERE id = ?");
        return $stmt->execute([$quantite, $id]);
    }
}