<?php
include("db_connection.php");

function numerate($indexedArray){
    $associativeArray = array();
    foreach ($indexedArray as $index => $value) {
        $associativeArray[$index] = $value;
    }
    return $associativeArray;
}

$result = $mysql->query("SELECT phone_number, full_name, question FROM calls");
$arr = array();

while ($row = $result->fetch_assoc()) {
    array_push($arr, ["phoneNumber" => $row["phone_number"],
                                      "fullName" => $row["full_name"],
                                      "question" => $row["question"]]);
}

echo(json_encode(numerate($arr)));