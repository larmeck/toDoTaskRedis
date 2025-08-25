<?php
require __DIR__ . '/config.php';

$data = json_decode(file_get_contents('php://input'), true);
$title = trim($data['task'] ?? ''); // frontend field name "task"

if ($title === '') {
    echo json_encode(['status' => 'error', 'message' => 'Empty task']);
    exit;
}

// 1️⃣ Insert into DB
$stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
$stmt->execute(['title' => $title]);

// 2️⃣ Push to Redis list
$redis->rPush('tasks:list', $title);

echo json_encode(['status' => 'success']);
