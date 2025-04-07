<?php
include("db_connection.php");
header("Content-Type: application/json");

$name = '';
if (!isset($_GET['name'])){
    return_error("No name was provides for searching.");
}

$name = $_GET['name'];

$data = db_get_data_by_name($mysql,$name);

echo json_encode($data);
?>