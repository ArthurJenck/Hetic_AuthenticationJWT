<html>

<body>
    <?php
    $token = $_COOKIE["token"];
    if (!$token) {
        // header("Location: ../login/");
    }
    ?>

    <h1>Tableau de bord</h1>