<?php
require __DIR__ . '/config.php';

$data = json_decode(file_get_contents('php://input'), true);
$title = trim($data['task'] ?? '');

if ($title === '') {
    echo json_encode(['status'=>'error','message'=>'Task not found']);
    exit;
}

// 1️⃣ Delete from MySQL
$stmt = $pdo->prepare("DELETE FROM tasks WHERE title=:title LIMIT 1");
$stmt->execute(['title'=>$title]);

// 2️⃣ Remove from Redis list
$redis->lRem('tasks:list', $title, 1);

echo json_encode(['status'=>'success']);
