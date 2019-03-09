<?php
require_once ('config/config.php');
require_once ('connector/mysql.php');

var_dump(NUMBER_ITEMS_MIGRATE);
// create object to mysql connection
$mysql = new mysqlConector();
$connector = $mysql->mysqliOpen(ORIGIN_DB_HOST, ORIGIN_DB_USER, ORIGIN_DB_PASS, ORIGIN_DB_NAME);

$sql = "SELECT * FROM node";
$result = $mysql->mysqliQuery($connector, $sql);
var_dump($result);

?>
hola