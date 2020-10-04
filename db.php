<?php
$server = "localhost";
$user = "root";
$pass = "root";
$database = "test";

$db = new mysqli($server, $user, $pass, $database);

$db -> set_charset("utf-8");
?>