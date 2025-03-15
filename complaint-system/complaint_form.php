<?php
include 'db_connect.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    // Redirect back if email is not provided
    header("Location: email_form.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll = $_POST['roll'];
    $name = $_POST['name'];
    $complaint = $_POST['complaint'];
    
    $sql = "INSERT INTO feedbacks (email, roll, name, complaint, feedback, status) VALUES (?, ?, ?, ?, '', 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $roll, $name, $complaint);
    
    if ($stmt->execute()) {
        echo "Complaint submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complaint Form</title>
</head>
<body>
    <h2>File a Complaint</h2>
    <form method="post" action="">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <label for="roll">Roll Number:</label>
        <input type="text" id="roll" name="roll" required>
        <br><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="complaint">Complaint:</label>
        <textarea id="complaint" name="complaint" required></textarea>
        <br><br>
        <button type="submit">Submit Complaint</button>
    </form>
</body>
</html>