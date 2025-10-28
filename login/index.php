<html>

<body>
    <?php
    if (!isset($_COOKIE["token"])): ?>
        <form action="./login.php" method="POST">
            <input type="email" name="email">
            <input type="password" name="password">
            <button type="submit" value="login">Se connecter</button>
        </form>
    <?php else :
        header("Location: ../");
    endif; ?>