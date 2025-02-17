<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'nmc';
$username = 'root';
$password = '';

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read the file containing email addresses
    $file_content = file_get_contents('emails.txt');
    
    // Regular expression pattern for email addresses
    $pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
    
    // Extract email addresses
    $emails = array();
    if (preg_match_all($pattern, $file_content, $matches)) {
        $emails = $matches[0];
    }
    
    // Store emails in database
    $stmt = $pdo->prepare("INSERT INTO emails (email_address, date_added) VALUES (?, NOW())");
    
    foreach ($emails as $email) {
        try {
            $stmt->execute([$email]);
        } catch (PDOException $e) {
            // Skip duplicates or handle other errors
            continue;
        }
    }
    
    // Retrieve all emails from database
    $query = "SELECT email_address, date_added FROM emails ORDER BY date_added DESC";
    $result = $pdo->query($query);
    
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
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['email_address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_added']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    echo "</body></html>";
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>