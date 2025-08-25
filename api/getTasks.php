<?php
require __DIR__ . '/config.php';

// Redis list key
$listKey = 'tasks:list';

// 1️⃣ Try Redis list
if ($redis->exists($listKey)) {
    $tasks = $redis->lRange($listKey, 0, -1);
    // wrap strings in objects for consistent frontend
    $tasks = array_map(fn($t) => ['title' => $t], $tasks);
    echo json_encode($tasks);
    exit;
}

// 2️⃣ Fallback to DB
$stmt = $pdo->query("SELECT title FROM tasks ORDER BY id DESC");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3️⃣ Populate Redis list
foreach ($tasks as $t) {
    $redis->rPush($listKey, $t['title']);
}

echo json_encode($tasks);
