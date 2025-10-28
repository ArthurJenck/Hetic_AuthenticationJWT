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
                setcookie("token", $token, time() + 60 * 60 * 24, "/");
                echo "Bonjour $result->email ! <br/>";
                echo "Cookie mis : token {$token}";
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
