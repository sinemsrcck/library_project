<?php
// Start session to access logged-in user information
session_start();
// Include database connection file
require_once "db.php";
$conn = db();

// Get user ID from session, default to 0 if not logged in
$user_id = $_SESSION["user_id"] ?? 0;
// If user is not logged in, return 401 Unauthorized response
if ($user_id === 0) {
  http_response_code(401);
  echo json_encode(["error" => "unauthorized"]);
  exit;
}
// Arrays to store active books and due dates
$active = [];
$due = [];

// SQL query to get approved borrowings of the current user
$q = "
  SELECT b.title, br.borrow_date, br.due_date, br.id as borrow_id
  FROM borrowings br
  JOIN books b ON br.book_id = b.id
  WHERE br.user_id = ?
    AND br.status = 'approved'
  ORDER BY br.borrow_date DESC
";

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare($q);
// Bind user ID parameter to the query
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

// Loop through results and build response arrays
while ($r = $res->fetch_assoc()) {
    // Active borrowed books list
  $active[] = ["title" => $r["title"], "borrowed_on" => $r["borrow_date"], "borrow_id" => $r["borrow_id"]];
    // Due dates list
  $due[] = ["title" => $r["title"], "due_date" => $r["due_date"]];
}

// Set response type as JSON
header("Content-Type: application/json; charset=utf-8");
// Return active books and due dates as JSON
echo json_encode(["activeBooks" => $active, "dueDates" => $due], JSON_UNESCAPED_UNICODE);
