<?php
session_start();
require_once "db.php";
$conn = db();

$user_id = $_SESSION["user_id"] ?? 0;
if ($user_id === 0) {
  http_response_code(401);
  echo json_encode(["error" => "unauthorized"]);
  exit;
}

$active = [];
$due = [];

$q = "
  SELECT b.title, br.borrow_date, br.due_date, br.id as borrow_id
  FROM borrowings br
  JOIN books b ON br.book_id = b.id
  WHERE br.user_id = ?
    AND br.status = 'approved'
  ORDER BY br.borrow_date DESC
";
$stmt = $conn->prepare($q);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

while ($r = $res->fetch_assoc()) {
  $active[] = ["title" => $r["title"], "borrowed_on" => $r["borrow_date"], "borrow_id" => $r["borrow_id"]];
  $due[] = ["title" => $r["title"], "due_date" => $r["due_date"]];
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode(["activeBooks" => $active, "dueDates" => $due], JSON_UNESCAPED_UNICODE);
