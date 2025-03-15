<?php

include_once 'db.php';

$username = $password = "";
$usernameErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validation
    if (!preg_match('/^\w{5,}$/', $username)) {
        $usernameErr = "Only letters, numbers, and underscores are allowed";
    }

    if (strlen($username) < 5) {
        $usernameErr = "Username must be at least 5 characters";
    }

    if (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters";
    }

    if (empty($usernameErr) && empty($passwordErr)) {
        // Check if user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->close();

            header("Location: index.php");
            exit();
        } else {
            $usernameErr = "Username already exists";
        }
    }
}

// Fetch users
$users = array();
$stmt = $conn->prepare("SELECT username FROM users");
$stmt->execute();
$stmt->bind_result($username);
while ($stmt->fetch()) {
    $users[] = array('username' => $username);
}
$stmt->close();
$username = "";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Admin Panel</h1>
    <div>
        <form action="" method="post">
            Username: <input type="text" name="username" value="<?php echo $username; ?>" required>
            Password: <input type="password" name="password" required>
            <input type="submit" value="Add User">
        </form>
        <p>
            <span class="error"><?php echo $usernameErr; ?></span><br>
            <span class="error"><?php echo $passwordErr; ?></span>
        </p>
    </div>

    <div>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td>
                            <a href="delete-user.php?username=<?php echo $user['username']; ?>"
                                onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>