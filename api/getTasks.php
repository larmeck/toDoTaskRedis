<?php
require 'redis.php';

$tasks = $redis->lRange("todo_list", 0, -1); // Get all tasks
echo json_encode($tasks);
