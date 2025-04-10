<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "infocenter_db";
$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysql->connect_error) {
    die("Could not connect to DB" . $mysql->connect_error);
}
if (!$mysql->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $mysql->error);
}
# $mysql->close();
?>