<?php
$hn = "127.0.0.1";   // localhost yerine güvenli yol
$un = "root";
$pw = "";
$db = "library_db";
$port = 3307;       // XAMPP MySQL portu (çok önemli!)

$conn = new mysqli($hn, $un, $pw, $db, $port);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
?>