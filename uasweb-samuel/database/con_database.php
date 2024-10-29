<?php
$dbPath = __DIR__ . '/database.sqlite';
if (!file_exists($dbPath)) {
    $db = new SQLite3($dbPath);
} else {
    $db = new SQLite3($dbPath);
}

if (!$db) {
    die("Error: Gagal terhubung ke database");
}
?>
