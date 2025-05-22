<?php
include("db_connection.php");

$inputJSON = file_get_contents('php://input');

$data = json_decode($inputJSON, true);

$id = $data['id'];

$result = $mysql->query("DELETE FROM calls WHERE id=$id");

echo(json_encode(["status" => $result ? "ok" : "err"]));

$mysql->close();
?>