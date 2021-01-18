<?php @session_start();

static  $DB_HOST="localhost";
static  $DB_NAME="first";
static  $DB_USER="root";
static  $DB_PASS="5445";

function pdo_query($sql) {
    $num_args = func_num_args();
    $args = func_get_args();
    $args = array_slice($args, 1, --$num_args);

    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $dbh;
    try {
        $dbh=new PDO("mysql:host=".$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS,array(PDO::ATTR_PERSISTENT=>true,PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
        $stmt = $dbh->prepare($sql);
        $stmt->execute($args);
        $result = array();
        if (stripos($sql, "select") == 0) {
            $result = $stmt->fetchAll();
        } else if (stripos($sql, "insert") == 0) {
            $result = $dbh->lastInsertId();
        } else {
            $result = $stmt->rowCount();
        }
        $stmt->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_msg = "error occur";
        include("View/error.php");
        exit(0);
    }
    return null;
}