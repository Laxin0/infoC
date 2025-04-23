<?php
include("db_connection.php");

$inputJSON = file_get_contents('php://input');

$data = json_decode($inputJSON, true);

$name = $data['name'];
$content = $data['content'];
$parent_id = $data['parentId'];


$result = $mysql->query("INSERT INTO pages (name, parent_id, content) VALUES ('$name', '$content', '$parent_id')");

echo(json_encode(["status" => $result ? "ok" : "err"]));

$mysql->close();
?>