<?php

$host = "localhost";
$user = "root";
$pwd = "";
$db = "NMC";

$connection = new mysqli($host, $user, $pwd, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
