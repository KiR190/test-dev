<?php
ob_start();
header("Content-Type: application/json; charset=utf-8");

require 'config.php';
require 'Database/database.php';
require 'Controllers/GuestController.php';

$start_time = microtime(true);
$memory_start = memory_get_usage();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$controller = new GuestController(getConnection());
$controller->handleRequest($requestMethod, $id);

$end_time = microtime(true);
$execution_time = round(($end_time - $start_time) * 1000, 2);
$memory_usage = round((memory_get_usage() - $memory_start) / 1024, 2);

header("X-Debug-Time: $execution_time ms");
header("X-Debug-Memory: $memory_usage Kb");

ob_end_flush();
