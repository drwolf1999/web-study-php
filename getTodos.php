<?php
require_once("./include/db_info.php");

header("Content-Type: application/json");

$sql = "SELECT * FROM todos";

$todos = pdo_query($sql);

$ids = array();
$titles = array();
$descriptions = array();
$isDos = array();

foreach ($todos as $todo) {
    array_push($ids, $todo['id']);
    array_push($titles, $todo['title']);
    array_push($descriptions, $todo['description']);
    array_push($isDos, $todo['do']);
}

echo json_encode(array("title" => $titles, "description" => $descriptions, "do" => $isDos, "id" => $ids));