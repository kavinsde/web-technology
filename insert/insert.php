<?php

include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "New user created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}