<?php 
    require_once "util/vendor/autoload.php";

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    $key = "Aceasta este o cheie supersecreta";
    $iss_time = time();
    $payload = ["iss" => "http://localhost",
                "iat" => $iss_time,
                "exp" => $iss_time + 3600, 
                "user_id" => 1, 
                "email" => "user_email@gmail.com"            
                ];
    $jwt = JWT::encode($payload, $key, 'HS256');
    echo $jwt;

?>
