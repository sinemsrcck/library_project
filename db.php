<?php
require_once "config.php";

function db() {
    global $hn, $un, $pw, $db,$port;
    $conn = new mysqli($hn, $un, $pw, $db,$port);
    if ($conn->connect_error) die("Database connection failed: " . $conn->connect_error);
    $conn->set_charset("utf8mb4");
    return $conn;
}
//MySQL bağlantısı için fonksiyon.
