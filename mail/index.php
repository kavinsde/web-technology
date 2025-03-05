<?php
include_once 'db.php';

try {
    // Read the file containing email addresses
    $file_content = file_get_contents('emails.txt');
    if ($file_content === FALSE) {
        throw new Exception("Could not read the file");
    }
    
    // Regular expression pattern for email addresses
    $pattern = '/\S+@\S+\.\S+/';
    
    // Extract email addresses
    $emails = array();
    if (preg_match_all($pattern, $file_content, $matches)) {
        $emails = $matches[0];
    }
    
    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO emails (email_address, date_added) VALUES (?, NOW())");
    
    // Store emails in database
    foreach ($emails as $email) {
        $stmt->bind_param('s', $email);
        
        try {
            $stmt->execute();
        } catch (Exception $e) {
            continue;
        }
    }
    
    // Close the insert statement
    $stmt->close();
    
    // Retrieve all emails from database
    $result = $conn->query("SELECT email_address, date_added FROM emails ORDER BY date_added DESC");
    
    echo "<h1>Stored and Extracted Emails</h1>";

    echo "<ol>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" .$row['email_address'] . " - " . $row['date_added'] . "</li>";
    }
    echo "</ol>";

    $result->free();
    
    $conn->close();
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>