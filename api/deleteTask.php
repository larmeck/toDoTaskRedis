<?php
require 'redis.php';

$data = json_decode(file_get_contents("php://input"), true);
$task = $data["task"] ?? '';

if ($task !== '') {
    $redis->lRem("todo_list", $task, 1); // Remove one occurrence
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Task not found"]);
}
