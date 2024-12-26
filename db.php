<?php

function getDbConnection() {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    return $pdo;
}

?>
