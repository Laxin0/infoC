<?php
include("db_connection.php");

function numerate($indexedArray){
    $associativeArray = array();
    foreach ($indexedArray as $index => $value) {
        $associativeArray[$index] = $value;
    }
    return $associativeArray;
}

function return_test_info(){
    $response_arr = array(
        "name" => "aaaa",
        "content" => "bbbb",
        "child_names" => numerate(array("cccc", "dddd"))
    );
    
    echo json_encode($response_arr);
    exit();
}

function return_error($msg, $code=500){
    echo json_encode(["error" => $msg]);
    http_response_code($code);
    exit();
}

function db_get_data_by_name($connection, $name){
    $query = "SELECT id, path FROM nodes WHERE name='{$name}'";
    $result = $connection->query($query);
    
    $row = $result->fetch_assoc();
    
    $curent_id = $row["id"];
    $path = $row["path"];
    $content = file_get_contents("data/" . $path);
    
    $query = "SELECT name FROM nodes WHERE parent_id=$curent_id";
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
if (!isset($_GET['name'])){ //TODO: Read about error handling in php
    return_error("No name was provides for searching.");
}

$name = $_GET['name'];
$data = db_get_data_by_name($mysql, $name);
echo json_encode($data);

$mysql->close();

?>
