<?php
session_start();
require_once '../../../controller/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    AuthController::login();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (AuthController::isLoggedIn()) {
        // Redirect to the dashboard if already logged in
        AuthController::redirectToDashboard();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

</head>
<body>

<?php
if (isset($_SESSION['error-login'])) {
    echo '<div class="error-message">' . htmlspecialchars($_SESSION['error-login']) . '</div>';
    unset($_SESSION['error-login']);
}
?>

<div class="login-container">
    <div class="login-card">
        <img src="../../assets/logoProMax.jpg" alt="Logo" class="logo">
        <h2>SoftFootball</h2>
        <p>Connectez-vous pour accéder à votre espace.</p>

        <form action="Login.php" method="post">
            <div class="input-group">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" placeholder="Votre adresse mail" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>

            </div>

            <button type="submit">Se Connecter</button>
        </form>

        <div class="links">
            <p><a href="Signup.php">Créer un compte</a></p>
            <p><a href="ForgotPassword.php">Mot de passe oublié ?</a></p>
        </div>
    </div>
                <script>
                    const passwordInput = document.getElementById('password');
                    const eyeIcon = document.createElement('i');
                    eyeIcon.className = 'fas fa-eye-slash';
                    eyeIcon.style.cursor = 'pointer';
                    eyeIcon.onclick = function() {
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeIcon.className = 'fas fa-eye';
                        } else {
                            passwordInput.type = 'password';
                            eyeIcon.className = 'fas fa-eye-slash';
                        }
                    };
                    passwordInput.parentNode.appendChild(eyeIcon);
                </script>
</div>

</body>
</html>
