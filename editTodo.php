<?php
require_once("./include/db_info.php");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $do = $_POST['do'];
    $sql = "UPDATE todos SET `title` = ?, `description` = ?, `do` = ? WHERE `id` = ?";
    pdo_query($sql, $title, $description, $do, $id);
} else {
    //
}