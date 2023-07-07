<?php

include_once './config/database.php';
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");
header('Access-Control-Allow-Headers: Authorization, X-Requested-With');

$secret_key = "833F91ECA375974CBE23EE9C9AF49";

$jwt = null;

$databaseService = new DatabaseService();

$conn = $databaseService->getConnection();

$data = json_decode(file_get_contents('php://input'), true);



$authHeader = $_SERVER['HTTP_AUTHORIZATION'];




$arr = explode(" ", $authHeader);


// echo json_encode(array(
//     "message" => "sd" . $arr[1]
// ));
$jwt = $arr[1];

echo "token : " . $jwt . "\n";



if ($jwt) {

    try {
        $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
        // Access is granted. Add code of the operation here
        echo json_encode([
            "message" => "Access granted:",

        ]);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode([
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ]);
    }
}
