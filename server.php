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
    $query = "SELECT name, path FROM pages WHERE id='{$id}'";
    $result = $connection->query($query);
    
    $row = $result->fetch_assoc();
    
    $name = $row["name"];
    $path = $row["path"];
    $content = file_get_contents("data/" . $path);
    
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

function db_get_data_by_name($connection, $name){
    $query = "SELECT id, path FROM pages WHERE name='{$name}'";
    $result = $connection->query($query);
    
    $row = $result->fetch_assoc();
    
    $curent_id = $row["id"];
    $path = $row["path"];
    $content = file_get_contents("data/" . $path);
    
    $query = "SELECT name FROM pages WHERE parent_id=$curent_id";
    $result = $connection->query($query);
    
    $child_names = array();
    while ($row = $result->fetch_assoc()) {
        array_push($child_names, $row["name"]);
    }
    
    $data = array(
        "name" => $name,
        "content" => $content,
        "child_names" => numerate($child_names)
    );
    return $data;
}

header("Content-Type: application/json");

$name = '';
$data;

if (isset($_GET['name'])){
    $name = $_GET['name'];
    $data = db_get_data_by_name($mysql, $name);
    
}elseif(isset($_GET['id'])){
    $id = $_GET['id'];
    $data = db_get_data_by_id($mysql, $id);
}else{
    return_error("Neither name nor id was given.");
}

echo json_encode($data);

$mysql->close();

?>
