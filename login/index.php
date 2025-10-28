<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    if (!isset($_COOKIE["token"])): ?>
        <div class="container">
            <h1>Connexion</h1>
            <p>Veuillez entrer vos identifiants pour accéder au tableau de bord.</p>

            <form action="./login.php" method="POST">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" required placeholder="alicedupont@gmail.com">

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required placeholder="secret123">

                <button type="submit">Se connecter</button>
            </form>
        </div>
    <?php else :
        header("Location: ../");
    endif; ?>
</body>

</html>