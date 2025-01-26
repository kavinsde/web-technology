<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Log in</title>

    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Log in</h1>

    <?php

include "db.php";

session_start();
if (isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$usernameErr = $passwordErr = "";
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = test_input($_POST["username"]);

    if (!preg_match('/^\w{5,}$/', $username)) { // \w equals "[0-9A-Za-z_]"
        $usernameErr = "Only letters, numbers, and underscores are allowed";
    }

    $password = test_input($_POST["password"]);

    if (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters";
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    if ($result->num_rows === 0) {
        $usernameErr = "User not found";
    } else {
        $user = $result->fetch_assoc();

        if (!password_verify($password, $user["password"])) {
            $passwordErr = "Invalid password";
        } else {

            $_SESSION["username"] = $username;
            header("Location: index.php");
        }
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>" autocomplete=off required>
        <span class=" error">* <?php echo $usernameErr; ?></span>

        <br><br>

        <label for="password" name="password" value="<?php echo $password; ?>" required>Password</label>
        <input type="password" name="password" required>
        <span class="error">* <?php echo $passwordErr; ?></span>


        <br><br>

        <input type="submit" value="Log in" />
    </form>
    <br>
    <form action="register.php">

        <input type="submit" value="Register" />
    </form>
</body>

</html>