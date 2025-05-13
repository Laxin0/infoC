<?php
include("environment.php");

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);
$inputPassword = $data['password'];

if ($inputPassword === getenv("ADMIN_PASS")) {
    setcookie("isAdmin", "true", time() + 3600, "/");
    http_response_code(200);
    echo "OK";
} else {
    http_response_code(401);
    echo "Wrong password";
}
?>