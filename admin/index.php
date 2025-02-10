<?php
include 'db.php';

$email = $username = $password = "";
$usernameErr = $passwordErr = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = test_input($_POST["email"]);
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

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
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $username, $hash);
            $stmt->execute();
            $stmt->close();

            header("Location: index.php");
            exit();
        } else {
            $usernameErr = "Email or username already exists";
        }
    }
}

// Fetch users
$users = [];
$stmt = $conn->prepare("SELECT id, email, username FROM users");
$stmt->execute();
$stmt->bind_result($id, $email, $username);
while ($stmt->fetch()) {
    $users[] = ['id' => $id, 'email' => $email, 'username' => $username];
}
$stmt->close();
$username = $email = "";
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
            Email: <input type="email" name="email" value="<?php echo $email; ?>" required>
            Username: <input type="text" name="username" value="<?php echo $username; ?>" required>
            Date of Birth: <input type="password" name="password" required>
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
                    <th>Email</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>"
                                onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>