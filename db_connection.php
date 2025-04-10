<?php

function loadEnv($path)
{
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

loadEnv(__DIR__ . '/.env.local');
$dbhost = getenv("DB_HOST");
$dbuser = getenv("DB_USER");
$dbpass = getenv("DB_PASS");
$dbname = getenv("DB_NAME");

#echo $dbhost . "/" . $dbuser . "/" . $dbpass . "/" . $dbname . "<br>";

$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysql->connect_error) {
    die("Could not connect to DB" . $mysql->connect_error);
}
if (!$mysql->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $mysql->error);
}
# $mysql->close();
?>