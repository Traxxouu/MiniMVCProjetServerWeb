<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Utilisateur;

final class AuthController extends Controller
{
    // Affiche et traite le formulaire d'inscription
    public function inscription(): void
    {
        $erreur = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $prenom = trim($_POST['prenom'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $adresse = trim($_POST['adresse'] ?? '');
            
            // Validation
            if (empty($email) || empty($mot_de_passe) || empty($prenom) || empty($nom)) {
                $erreur = "Tous les champs obligatoires doivent être remplis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreur = "Format d'email invalide.";
            } elseif (strlen($mot_de_passe) < 6) {
                $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
            } else {
                // Création de l'utilisateur
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($email);
                $utilisateur->setMotDePasse(password_hash($mot_de_passe, PASSWORD_DEFAULT));
                $utilisateur->setPrenom($prenom);
                $utilisateur->setNom($nom);
                $utilisateur->setAdresse($adresse);
                
                if ($utilisateur->save()) {
                    header('Location: /connexion?success=inscription');
                    exit;
                } else {
                    $erreur = "Cette adresse email est déjà utilisée.";
                }
            }
        }
        
        $this->render('auth/inscription', params: [
            'title' => 'Inscription - Efrei Tech',
            'erreur' => $erreur
        ]);
    }

    // Affiche et traite le formulaire de connexion
    public function connexion(): void
    {
        $erreur = null;
        $success = $_GET['success'] ?? null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            
            $utilisateur = Utilisateur::findByEmail($email);
            
            if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
                // Connexion réussie
                $_SESSION['utilisateur_id'] = $utilisateur['id'];
                $_SESSION['utilisateur_nom'] = $utilisateur['prenom'] . ' ' . $utilisateur['nom'];
                
                header('Location: /');
                exit;
            } else {
                $erreur = "Email ou mot de passe incorrect.";
            }
        }
        
        $this->render('auth/connexion', params: [
            'title' => 'Connexion - Efrei Tech',
            'erreur' => $erreur,
            'success' => $success
        ]);
    }

    // Déconnexion
    public function deconnexion(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}