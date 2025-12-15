<?php
session_start();
require_once "db.php";
$conn = db();

echo "MySQL bağlantısı başarılı!<br><br>";

$result = $conn->query("SHOW TABLES");
if (!$result) die("Sorgu hatası: " . $conn->error);

echo "Veritabanındaki tablolar:<br>";
while ($row = $result->fetch_array()) {
    echo "- " . $row[0] . "<br>";
}

$result->close();
$conn->close();
