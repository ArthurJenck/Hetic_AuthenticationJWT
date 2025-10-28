<?php

include("../private.php");

function base64UrlEncode($data)
{
    $base64 = base64_encode($data);
    return rtrim(strtr($base64, '+/', '-_'), '=');
}

function generateJWT($secret)
{

    $header = (object)['alg' => 'HS256', 'typ' => 'JWT'];
    $payload = (object)['sub' => 123456, "iss" => "url-front.fr", 'aud' => 'url-back.fr', 'exp' => time() + 10, "iat" => time()];


    $headerBase64 = base64UrlEncode(json_encode($header));
    $payloadBase64 = base64UrlEncode(json_encode($payload));

    $signature = hash_hmac('sha256', "$headerBase64.$payloadBase64", $secret, true);
    $signatureBase64 = base64UrlEncode($signature);

    return "$headerBase64.$payloadBase64.$signatureBase64";
}

if (isset($_POST["email"]) && isset($_POST["password"])) {

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=authentification_avancee", "root", "");

        $stmt = $pdo->prepare("SELECT * FROM users where UPPER(email) = UPPER(:email)");
        $stmt->bindParam(':email', $_POST["email"]);
        $stmt->execute();


        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($result !== false) {
            if ($result->password === $_POST["password"]) {
                $token = generateJWT($jwt_key);
                setcookie("token", $token, time() + 30 * 60, "/");
                header("Location: ../dashboard/");
            } else {
                echo 'Identifiants incorrects';
            }
        } else {
            echo "Utilisateur non trouvé (normalement on dirait juste identifiants incorrects mais là pour tester je suis plus explicite)";
        }
    } catch (\Throwable $th) {
        var_dump($th->getMessage());
    }
}

function validateJWT($token, $key)
{
    $key = base64_encode($key);
    $tokenArray = explode(".", $_COOKIE["token"]);


    if (!isset($tokenArray[0]) || !isset($tokenArray[1])) {
        return false;
    }

    $headers = base64_decode($tokenArray[0]);
    $payload = base64_decode($tokenArray[1]);
    $signature = $tokenArray[2];

    var_dump($headers);
    var_dump($payload);

    if (!json_decode($headers) || !json_decode($payload)) {
        return false;
    }



    return $headers;
}
