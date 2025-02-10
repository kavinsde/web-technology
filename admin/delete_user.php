<?php

include 'db.php';

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();
    
    header("Location: index.php");
    exit();
}