<?php
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

echo "MySQL bağlantısı başarılı!<br><br>";

// Test için tabloları listeleyelim
$query = "SHOW TABLES";
$result = $conn->query($query);

if (!$result) {
    die("Sorgu hatası: " . $conn->error);
}

echo "Veritabanındaki tablolar:<br>";
while ($row = $result->fetch_array()) {
    echo "- " . $row[0] . "<br>";
}

$result->close();
$conn->close();
?>
