<?php include 'dashboard.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kemajuan Proyek</title>
    <style>
        .progress-bar {
            width: 100%;
            background-color: #ddd;
        }
        .progress {
            height: 30px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Dashboard Kemajuan Proyek</h1>
    <div>
        <p>Persentase Kemajuan Proyek: <?= round($progress) ?>%</p>
        <div class="progress-bar">
            <div class="progress" style="width: <?= round($progress) ?>%;">
                <?= round($progress) ?>%
            </div>
        </div>
    </div>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Tugas</th>
                <th>Status</th>
                <th>Progres (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['name']) ?></td>
                <td><?= htmlspecialchars($task['status']) ?></td>
                <td><?= htmlspecialchars($task['progress']) ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
