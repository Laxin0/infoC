<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "tree";
$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysql->connect_error) {
    return_error("Could not connect to DB" . $mysql->connect_error);
}

# $mysql->close();
?>