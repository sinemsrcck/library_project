

<?php
session_start();

require_once "db.php";
$conn = db();

?>
<?php
// seed_books_openlibrary.php
// Reads isbns.txt, fetches metadata from Open Library, inserts into MySQL.

ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- settings ---
$ISBN_FILE = __DIR__ . "/isbns.txt";
$BATCH_SIZE = 20;            // Open Library API batch size (keep 20-50 safe)
$SLEEP_MS = 200;             // small delay to be nice to API

if (!file_exists($ISBN_FILE)) {
  die("isbns.txt not found at: $ISBN_FILE");
}

$raw = file($ISBN_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$isbns = [];

foreach ($raw as $line) {
  $isbn = preg_replace('/[^0-9Xx]/', '', trim($line));
  if ($isbn !== "") $isbns[] = strtoupper($isbn);
}
//$isbns = array_values(array_unique($isbns));
// --- DEBUG: kaç satır, kaç benzersiz? ---
$lineCount = count($isbns);
$uniqueCount = count(array_unique($isbns));

if (count($isbns) === 0) die("No ISBNs found in isbns.txt");

// Ensure cover_url exists (safe try)
try {
  $conn->query("ALTER TABLE books ADD COLUMN cover_url VARCHAR(500) NULL");
} catch (Throwable $e) {
  // ignore if already exists
}

// Prepare insert (avoid duplicates by isbn)
$ins = $conn->prepare("
  INSERT INTO books
    (title, author, category, year, isbn, cover_url, is_available, total_copies, available_copies)
  VALUES
    (?, ?, ?, ?, ?, ?, 1, ?, ?)
");



function http_get_json($url) {
  // Use curl if available; fallback to file_get_contents
  if (function_exists("curl_init")) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_TIMEOUT => 20,
      CURLOPT_USERAGENT => "LibraryProjectSeeder/1.0"
    ]);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);
    if ($res === false || $code >= 400) {
      throw new Exception("HTTP error $code $err");
    }
    $data = json_decode($res, true);
    if (!is_array($data)) throw new Exception("Invalid JSON");
    return $data;
  } else {
    $res = @file_get_contents($url);
    if ($res === false) throw new Exception("file_get_contents failed");
    $data = json_decode($res, true);
    if (!is_array($data)) throw new Exception("Invalid JSON");
    return $data;
  }
}

function pick_year($publish_date) {
  if (!$publish_date) return 0;
  if (preg_match('/(19|20)\d{2}/', $publish_date, $m)) return (int)$m[0];
  return 0;
}

function pick_category($subjects) {
  // Keep it simple: map to broad categories
  if (!is_array($subjects) || count($subjects) === 0) return "general";
  $name = strtolower($subjects[0]["name"] ?? $subjects[0] ?? "");
  if (str_contains($name, "computer") || str_contains($name, "program")) return "science";
  if (str_contains($name, "fiction") || str_contains($name, "novel")) return "novel";
  if (str_contains($name, "history")) return "history";
  if (str_contains($name, "business") || str_contains($name, "management")) return "business";
  return "general";
}

$total = count($isbns);
$inserted = 0; $skipped = 0; $failed = 0;

echo "<pre>";
echo "Total ISBNs: $total\n\n";

for ($i=0; $i<$total; $i += $BATCH_SIZE) {
  $chunk = array_slice($isbns, $i, $BATCH_SIZE);
  $keys = array_map(fn($x) => "ISBN:" . $x, $chunk);

  $url = "https://openlibrary.org/api/books?bibkeys=" . urlencode(implode(",", $keys)) . "&format=json&jscmd=data";

  try {
    $data = http_get_json($url);
  } catch (Throwable $e) {
    echo "Batch fetch failed at index $i: " . $e->getMessage() . "\n";
    $failed += count($chunk);
    continue;
  }

  foreach ($chunk as $isbn) {

    $k = "ISBN:" . $isbn;
    $book = $data[$k] ?? null;
    if (!$book) {
      $failed++;
      echo "FAIL (not found in OpenLibrary): $isbn\n";
      continue;
    }

    $title = trim($book["title"] ?? "");
    $author = "";
    if (!empty($book["authors"]) && is_array($book["authors"])) {
      $author = trim($book["authors"][0]["name"] ?? "");
    }

    $year = pick_year($book["publish_date"] ?? "");
    $category = pick_category($book["subjects"] ?? []);

    // cover (Open Library covers endpoint works well even if json cover missing)
    $cover_url = "https://covers.openlibrary.org/b/isbn/" . rawurlencode($isbn) . "-M.jpg";

    if ($title === "") {
      $failed++;
      echo "FAIL (empty title): $isbn\n";
      continue;
    }

 // === HYBRID COPY POLICY (PROFESSIONAL) ===
$cat = strtolower($category);

if (in_array($cat, ['science', 'programming', 'computer'])) {
    $totalCopies = rand(2, 5);
} elseif (mt_rand() / mt_getrandmax() < 0.25) {
    $totalCopies = rand(2, 3);
} else {
    $totalCopies = 1;
}

$availableCopies = $totalCopies;

// 1) Bu ISBN’den şu an DB’de kaç tane var?
$ins->bind_param(
  "sssissii",
  $title,
  $author,
  $category,
  $year,
  $isbn,
  $cover_url,
  $totalCopies,
  $availableCopies
);

try {
  $ins->execute();
  $inserted++;
  echo "OK: $isbn | $title | copies=$totalCopies\n";
} catch (Throwable $e) {
  $failed++;
  echo "DB FAIL: $isbn | " . $e->getMessage() . "\n";
  echo "MYSQL ERRNO: {$conn->errno} | MYSQL ERROR: {$conn->error}\n";
}
  }

  usleep($SLEEP_MS * 1000);
}

echo "\n--- DONE ---\n";
echo "Inserted: $inserted\n";
echo "Skipped:  $skipped\n";
echo "Failed:   $failed\n";
echo "</pre>";



$ins->close();
$conn->close();

$existing = (int)$existing;
