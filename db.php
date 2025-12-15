<?php
require_once "config.php";

function db() {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die("Database connection failed: " . $conn->connect_error);
    $conn->set_charset("utf8mb4");
    return $conn;
}
