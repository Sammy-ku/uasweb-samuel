<?php
require_once __DIR__ . '/../logger.php';
$logs = new Logger();

try {
    require_once __DIR__ . '/../con_database.php';

    // Buat koneksi ke database SQLite
    $db = new SQLite3($dbPath);

    // Tabel `tasks` untuk menyimpan informasi tugas proyek
    $query = "
        CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            status VARCHAR(20) DEFAULT 'belum mulai',
            progress INTEGER DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $db->exec($query);

    // Trigger untuk memperbarui kolom `updated_at` di tabel `tasks` setiap kali ada pembaruan data
    $triggerQuery = "
        CREATE TRIGGER IF NOT EXISTS update_tasks_updated_at
        AFTER UPDATE ON tasks
        FOR EACH ROW
        BEGIN
            UPDATE tasks SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
        END;
    ";
    $db->exec($triggerQuery);

} catch (Exception $e) {
    $logs->error($e->getMessage());
}
?>
