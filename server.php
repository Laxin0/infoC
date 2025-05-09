<?php
include("db_connection.php");

function numerate($indexedArray){
    $associativeArray = array();
    foreach ($indexedArray as $index => $value) {
        $associativeArray[$index] = $value;
    }
    return $associativeArray;
}

function return_error($msg, $code=500){
    echo json_encode(["error" => $msg]);
    http_response_code($code);
    exit();
}

function db_get_data_by_id($connection, $id){ # Get name directly from the button
    $query = "SELECT name, content FROM pages WHERE id=$id";
    $result = $connection->query($query);
    
    $row = $result->fetch_assoc();
    
    $name = $row["name"];
    $content = $row["content"]; 
    
    $query = "SELECT id, name FROM pages WHERE parent_id=$id";
    $result = $connection->query($query);
    
    $child_names = array();
    while ($row = $result->fetch_assoc()) {
        array_push($child_names, ["id" => $row["id"], "name" => $row["name"]]);
    }
    
    $data = array(
        "name" => $name,
        "content" => $content,
        "child_nodes" => numerate($child_names)
    );
    return $data;
}

header("Content-Type: application/json");

$name = '';
$data;

if(!isset($_GET['id'])){
    return_error("Id wasn't provided.");
}else{
    $id = $_GET['id'];
    $data = db_get_data_by_id($mysql, $id);
    echo json_encode($data);
}

$mysql->close();

?>
