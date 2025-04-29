<?php
include("db_connection.php");

function numerate($indexedArray){
    $associativeArray = array();
    foreach ($indexedArray as $index => $value) {
        $associativeArray[$index] = $value;
    }
    return $associativeArray;
}

$result = $mysql->query("SELECT calls.id, phone_number, full_name, question, pages.name AS source_page_name, is_solved FROM calls JOIN pages ON calls.source_page_id=pages.id");
$arr = array();

while ($row = $result->fetch_assoc()) {
    array_push($arr, ["id" => $row["id"],
                                      "phoneNumber" => $row["phone_number"],
                                      "fullName" => $row["full_name"],
                                      "question" => $row["question"],
                                      "sourcePage" => $row["source_page_name"],
                                      "isSolved" => $row["is_solved"]]);
}

echo(json_encode(numerate($arr)));