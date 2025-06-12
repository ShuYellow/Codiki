<?php //config.php
const DB_HOST="192.168.3.152";
const DB_NAME="Demo_Exam";
const DB_USER="filimonov";
const DB_PASS="Moreman4ik4";
const DB_PORT="3306";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
$db->set_charset('utf8');

$_SERVER['db'] = $db;
?>
