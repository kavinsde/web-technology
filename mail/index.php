<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'nmc';
$username = 'root';
$password = '';

try {
    // Create database connection (PHP 5 compatible mysql connection)
    $mysqli = new mysqli($host, $username, $password, $dbname);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    // Read the file containing email addresses
    $file_content = file_get_contents('emails.txt');
    if ($file_content === FALSE) {
        throw new Exception("Could not read the file");
    }
    
    // Regular expression pattern for email addresses
    $pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
    
    // Extract email addresses
    $emails = array();
    if (preg_match_all($pattern, $file_content, $matches)) {
        $emails = $matches[0];
    }
    
    // Prepare the insert statement
    $stmt = $mysqli->prepare("INSERT INTO emails (email_address, date_added) VALUES (?, NOW())");
    
    if ($stmt === FALSE) {
        throw new Exception("Error preparing statement: " . $mysqli->error);
    }
    
    // Store emails in database
    foreach ($emails as $email) {
        // Bind parameters (PHP 5 style)
        $stmt->bind_param('s', $email);
        
        // Execute statement
        try {
            $stmt->execute();
        } catch (Exception $e) {
            // Skip duplicates or handle other errors
            continue;
        }
    }
    
    // Close the insert statement
    $stmt->close();
    
    // Retrieve all emails from database
    $result = $mysqli->query("SELECT email_address, date_added FROM emails ORDER BY date_added DESC");
    
    if ($result === FALSE) {
        throw new Exception("Error in select query: " . $mysqli->error);
    }
    
    // Display results
    echo "<html><head><title>Email List</title>";
    echo "<style>
            table { border-collapse: collapse; width: 100%; }
            th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
            th { background-color: #f2f2f2; }
          </style>";
    echo "</head><body>";
    
    echo "<h2>Extracted and Stored Emails</h2>";
    echo "<table>";
    echo "<tr><th>Email Address</th><th>Date Added</th></tr>";
    
    // PHP 5 compatible result fetching
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['email_address'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['date_added'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    echo "</body></html>";
    
    // Free the result set
    $result->free();
    
    // Close the connection
    $mysqli->close();
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>