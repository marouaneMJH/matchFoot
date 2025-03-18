<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup page</title>
    <link rel="stylesheet" href="../../styles/styles12.css">
</head>
<body>
    <form id="signup-form">
        <div class="signup-container">
            <div class="signup-card">
                <h2>Créer un compte</h2>
                <p>Inscrivez-vous pour rejoindre la communauté.</p>
        
                <form action="#" method="POST" id="signupForm">
                    <div class="input-group">
                        <label for="username">Nom </label>
                        <input type="text" id="username" name="username" placeholder="Entrez votre nom " required>
                    </div>
                    <div class="input-group">
                        <label for="displayName">Prénom</label>
                        <input type="text" id="displayName" name="displayName" placeholder="Entrez votre prénom" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Votre email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Choisissez un mot de passe" required>
                    </div>
                    <div class="input-group">
                        <label for="confirmPassword">Confirmer le mot de passe</label>
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirmez votre mot de passe" required>
                    </div>
                    <div class="input-group">
                        <label for="profileImage">Image de profil (optionnel)</label>
                        <input type="file" id="profileImage" name="profileImage">
                    </div>
                    <button type="submit">S'inscrire</button>
                </form>
                <div class="links">
                    <a href="Login.php">Déjà inscrit ? Connectez-vous ici</a>
                </div>
            </div>
        </div>
    </form>

    <script>
        const form = document.getElementById('signup-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
           // const fileInput = document.getElementById("profile_image");
           // console.log(fileInput);
           // formData.append("file", fileInput.files[0]);
            fetch('http://efoot/signup', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
