<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    if (isset($_COOKIE["token"])) :
    ?>
        <div class="container">
            <h1>Tableau de bord</h1>
            <p>Votre session est active. Le cookie expirera dans 30 secondes, le token dans 10.</p>

            <div class="token-display">
                <strong>Token JWT (valide 10 secondes)</strong><br>
                <?php
                include("../private.php");
                include("../login/login.php");

                var_dump(validateJWT($_COOKIE["token"], $jwt_key));

                // echo $_COOKIE["token"];


                ?>
            </div>

            <a href="../">Retour à l'accueil</a>
        </div>

    <?php else : ?>
        <div class="container">
            <h1>401 Unauthorized</h1>
            <p class="error">Vous n'avez pas la permission d'accéder à cette page.</p>
            <p>Veuillez vous connecter pour continuer.</p>

            <a href="../login/">Se connecter</a>
        </div>
    <?php endif; ?>
</body>

</html>