<?php
require_once "util/vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;




$key = "Aceasta este o cheie supersecreta";

if (! isset($argv[1])) {
    exit('Please provide a key to verify');
}

$jwt = $argv[1];

try{
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    print_r((array) $decoded);
} catch(Exception $e){
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>
