<?php
include 'db.php';

$sql = "SELECT username, password FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
</head>
<body>
    <h2>Users List</h2>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           echo $row['username'] . " " . $row['password'] . "<br>";
        }
    } else {
        echo "No users found";
    }
    ?>
    <p><a href="index.html">Back to entry form</a></p>
</body>
</html>

<?php
$conn->close();
?>