<?php
require_once __DIR__ . '/con_database.php';

$query = "SELECT * FROM tasks";
$result = $db->query($query);
$tasks = [];
$completedTasks = 0;

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $tasks[] = $row;
    if ($row['status'] == 'selesai') {
        $completedTasks++;
    }
}

// Debug: Tampilkan isi array $tasks
echo "<pre>";
print_r($tasks);
echo "</pre>";

$totalTasks = count($tasks);
$progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
?>
