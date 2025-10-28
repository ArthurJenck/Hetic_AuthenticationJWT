<html>

<body>

    <?php


    function base64UrlEncode($data)
    {
        // Encodage base64 standard
        $base64 = base64_encode($data);
        // Conversion en base64url : remplacer +, / et supprimer le padding =
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

    echo generateJWT("EEF5DBE1F22327DD78F4A9B5613A5");
