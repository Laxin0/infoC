<?php
include("db_connection.php");

$inputJSON = file_get_contents('php://input');

$data = json_decode($inputJSON, true);

$phone_number = $data['phoneNumber'];
$full_name = $data['fullName'];
$question = $data['question'];
$source_page = $data['sourcePage'];

$result = $mysql->query("INSERT INTO calls (phone_number, full_name, question, source_page_id) VALUES ('$phone_number', '$full_name', '$question', '$source_page')");

echo(json_encode(["status" => $result ? "ok" : "err"]));

$mysql->close();
?>