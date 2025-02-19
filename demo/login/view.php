<?php
include 'db.php';

$sql = "SELECT username, password FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>
    <h2>Users List</h2>
    <?php
    if ($result->num_rows > 0) {
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                    </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["username"]."</td><td>".$row["password"]."</td></tr>";
            }
            echo "</table>";
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