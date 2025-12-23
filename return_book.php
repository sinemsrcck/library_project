<?php
session_start();
require_once "db.php";
$conn = db();

header("Content-Type: application/json"); //Json döndüreceğim.

if (!isset($_SESSION["user_id"])) { //kullanıcı login değilse
    http_response_code(401);
    echo json_encode(["success" => false, "msg" => "Unauthorized"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true); //PHP’nin dışarıdan (özellikle JS/AJAX’tan) gelen ham veriyi okuyup diziye çevirmesi için.
    $borrow_id = $input["borrow_id"] ?? 0;//iade için ıd
    $user_id = $_SESSION["user_id"];//user id

    if (!$borrow_id) {
        echo json_encode(["success" => false, "msg" => "Invalid ID"]);
        exit;
    }

    // 1. Verify that this borrowing belongs to the user and is indeed 'active' ('approved')
    $stmt = $conn->prepare("SELECT book_id FROM borrowings WHERE id = ? AND user_id = ? AND status = 'approved'");
    $stmt->bind_param("ii", $borrow_id, $user_id);  //iade id si kullanıcı id si bu mu? ve aktif mi?
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {//Katıt yoksa.
        echo json_encode(["success" => false, "msg" => "Borrowing record not found or already returned."]);
        exit;
    }

    $row = $res->fetch_assoc(); //Bir satırı alır ve PHP’de anahtar–değer dizisi yapar.
    $book_id = $row["book_id"];//kitap id si.

    // 2. Update the borrowing record
    $updBorrow = $conn->prepare("UPDATE borrowings SET status = 'returned', return_date = CURDATE() WHERE id = ?");
    $updBorrow->bind_param("i", $borrow_id);//iade is di .

    if ($updBorrow->execute()) {
        // 3. Mark the book as available again
        $updBook = $conn->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ? AND available_copies < total_copies");
//Belirli bir kitabın (id = ?) mevcut kopya sayısını 1 artırır, ama toplam kopyayı aşmasına ASLA izin vermez.
        $updBook->bind_param("i", $book_id);
        $updBook->execute();

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "msg" => "Database error updating borrowing."]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Invalid method"]);
}
