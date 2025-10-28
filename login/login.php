<?php


function base64UrlEncode($data)
{
    $base64 = base64_encode($data);
    return rtrim(strtr($base64, '+/', '-_'), '=');
}

function generateJWT($secret)
{

    $header = (object)['alg' => 'HS256', 'typ' => 'JWT'];
    $payload = (object)['sub' => 123456, "iss" => "???", 'aud' => '???', 'exp' => time() + 60 * 60 * 24, "iat" => time()];


    $headerBase64 = base64UrlEncode(json_encode($header));
    $payloadBase64 = base64UrlEncode(json_encode($payload));

    $signature = hash_hmac('sha256', "$headerBase64.$payloadBase64", $secret, true);
    $signatureBase64 = base64UrlEncode($signature);

    return "$headerBase64.$payloadBase64.$signatureBase64";
}

if (isset($_POST["email"]) && isset($_POST["password"])) {

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=jwt_generation", "root", "");

        $stmt = $pdo->prepare("SELECT * FROM users where UPPER(email) = UPPER(:email)");
        $stmt->bindParam(':email', $_POST["email"]);
        $stmt->execute();


        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($result !== false) {
            if ($result->password === $_POST["password"]) {
                $token = generateJWT("EEF5DBE1F22327DD78F4A9B5613A5");
                setcookie("token", $token, time() + 10, "/");
                header("Location: ../dashboard/");
            } else {
                echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - JWT Auth</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .error-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 400px;
        }
        h1 {
            color: #e74c3c;
            margin-bottom: 15px;
            font-size: 1.8em;
        }
        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        a {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>Erreur</h1>
        <p>Identifiants incorrects</p>
        <a href="./">← Réessayer</a>
    </div>
</body>
</html>';
            }
        } else {
            echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - JWT Auth</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .error-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 450px;
        }
        h1 {
            color: #e74c3c;
            margin-bottom: 15px;
            font-size: 1.8em;
        }
        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .note {
            font-size: 0.85em;
            color: #999;
            font-style: italic;
            margin-top: 10px;
        }
        a {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>Utilisateur non trouvé</h1>
        <p class="note">(Normalement on dirait juste "identifiants incorrects" mais là pour tester je suis plus explicite)</p>
        <a href="./">← Réessayer</a>
    </div>
</body>
</html>';
        }
    } catch (\Throwable $th) {
        echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - JWT Auth</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .error-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 500px;
        }
        h1 {
            color: #e74c3c;
            margin-bottom: 15px;
            font-size: 1.8em;
        }
        .error-message {
            color: #666;
            margin-bottom: 20px;
            font-family: monospace;
            background: #f5f5f5;
            padding: 15px;
            border-radius: 10px;
            word-break: break-word;
        }
        a {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>Erreur technique</h1>
        <div class="error-message">' . htmlspecialchars($th->getMessage()) . '</div>
        <a href="./">← Retour</a>
    </div>
</body>
</html>';
    }
}
