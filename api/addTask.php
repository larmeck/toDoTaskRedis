<?php
require 'redis.php';

$data = json_decode(file_get_contents("php://input"), true);
$task = trim($data["task"] ?? '');

if ($task !== '') {
    $redis->rPush("todo_list", $task); // Add to Redis list
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Empty task"]);
}
