<?php
include 'db_connect.php';

// Handle feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $feedback = $_POST['feedback'];
    
    $sql = "UPDATE feedbacks SET feedback = ?, status = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $feedback, $id);
    
    if ($stmt->execute()) {
        echo "Feedback submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Display pending complaints
$sql = "SELECT * FROM feedbacks WHERE status = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
</head>
<body>
    <h2>Pending Complaints</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
            echo "<p><strong>Roll:</strong> " . htmlspecialchars($row['roll']) . "</p>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
            echo "<p><strong>Complaint:</strong> " . htmlspecialchars($row['complaint']) . "</p>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<label for='feedback'>Feedback:</label>";
            echo "<textarea id='feedback' name='feedback' required></textarea>";
            echo "<br><br>";
            echo "<button type='submit'>Submit Feedback</button>";
            echo "</form>";
            echo "</div><hr>";
        }
    } else {
        echo "No pending complaints.";
    }
    ?>
</body>
</html>