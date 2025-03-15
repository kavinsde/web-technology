<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Check for pending complaints
    $sql = "SELECT * FROM feedbacks WHERE email = ? AND status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Your complaint is submitted.";
    } else {
        // Redirect to complaint form with email
        header("Location: complaint_form.php?email=" . urlencode($email));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Form</title>
</head>
<body>
    <h2>Enter Your Email</h2>
    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Go to Complaint Form</button>
    </form>
</body>
</html>