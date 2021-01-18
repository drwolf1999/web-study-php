<?php
require_once("./include/db_info.php");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO todos (`title`, `description`, `do`) VALUES (?, ?, ?)";
    pdo_query($sql, $title, $description, 0);
} else {
    //
}