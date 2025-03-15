<?php

include_once 'db.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
