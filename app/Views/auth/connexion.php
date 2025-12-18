<h2>Se connecter</h2>

<?php if (isset($success) && $success === 'inscription'): ?>
    <div class="alert alert-success">
        Inscription réussie ! Vous pouvez maintenant vous connecter.
    </div>
<?php endif; ?>

<?php if (isset($erreur)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($erreur) ?>
    </div>
<?php endif; ?>

<div class="form-container">
    <form method="POST" action="/connexion">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required 
                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <p style="margin-top: 1.5rem; text-align: center;">
        Pas encore de compte ? <a href="/inscription">S'inscrire</a>
    </p>
</div>