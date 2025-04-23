<?php
include("db_connection.php");

$inputJSON = file_get_contents('php://input');

$data = json_decode($inputJSON, true);

$id = $data['id'];
$name = $data['name'];
$content = $data['content'];

$result = $mysql->query("UPDATE pages SET name='$name', content='$content' WHERE id=$id");

echo(json_encode(["status" => $result ? "ok" : "err"]));

$mysql->close();
?>