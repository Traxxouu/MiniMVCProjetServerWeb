<h2>Créer un compte</h2>

<?php if (isset($erreur)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($erreur) ?>
    </div>
<?php endif; ?>

<div class="form-container">
    <form method="POST" action="/inscription">
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required 
                   value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required 
                   value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required 
                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6">
            <small>Minimum 6 caractères</small>
        </div>

        <div class="form-group">
            <label for="adresse">Adresse</label>
            <textarea id="adresse" name="adresse" rows="3"><?= isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : '' ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>

    <p style="margin-top: 1.5rem; text-align: center;">
        Vous avez déjà un compte ? <a href="/connexion">Se connecter</a>
    </p>
</div>