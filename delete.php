<?php
include('db_connection.php');

function delete_by_id($connection, $id){
    $result = $connection->query("SELECT id FROM pages WHERE parent_id=$id");
    while ($row = $result->fetch_assoc()) {
        delete_by_id($connection, $row["id"]);
    }
    $result = $connection->query("DELETE FROM pages WHERE id=$id");
    if (!$result){
        echo(json_encode(["status" => "err"]));
        exit();
    }
}

$inputJSON = file_get_contents('php://input');

$data = json_decode($inputJSON, true);

if (!$data['id']){
    echo(json_encode(["status" => "err"]));
    exit();
}

delete_by_id($mysql, $data['id']);
echo(json_encode(["status" => "ok"]));

$mysql->close();
?>