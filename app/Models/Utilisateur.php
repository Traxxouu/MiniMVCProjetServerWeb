<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Utilisateur
{
    private $id;
    private $email;
    private $mot_de_passe;
    private $prenom;
    private $nom;
    private $adresse;

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }
    public function getMotDePasse() { return $this->mot_de_passe; }
    public function setMotDePasse($mot_de_passe) { $this->mot_de_passe = $mot_de_passe; }
    public function getPrenom() { return $this->prenom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function getNom() { return $this->nom; }
    public function setNom($nom) { $this->nom = $nom; }
    public function getAdresse() { return $this->adresse; }
    public function setAdresse($adresse) { $this->adresse = $adresse; }

    // Crée un nouvel utilisateur
    public function save()
    {
        $pdo = Database::getPDO();
        try {
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe, prenom, nom, adresse) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([
                $this->email,
                $this->mot_de_passe,
                $this->prenom,
                $this->nom,
                $this->adresse
            ]);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    // Récupère un utilisateur par email
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère un utilisateur par ID
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}