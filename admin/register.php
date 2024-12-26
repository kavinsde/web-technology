<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php session_start();

if (isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$email = $username = $password = $cpassword = "";
$emailErr = $usernameErr = $passwordErr = $cpasswordErr = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    include "db.php";

    $email = test_input($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    $username = test_input($_POST["username"]);

    if (!preg_match('/^\w{5,}$/', $username)) {
        $usernameErr = "Only letters, numbers, and underscores are allowed";
    }

    if (strlen($username) < 5) {
        $usernameErr = "Username must be at least 5 characters";
    }

    $password = test_input($_POST["password"]);

    if (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters";
    }

    $cpassword = test_input($_POST["cpassword"]);

    if ($password !== $cpassword) {
        $cpasswordErr = "Passwords do not match";
    }

    if (empty($emailErr) && empty($usernameErr) && empty($passwordErr) && empty($cpasswordErr)) {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        if ($result->num_rows === 0) {

            $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $username, password_hash($password, PASSWORD_DEFAULT));

            $stmt->execute();

            $stmt->close();

            header("Location: login.php");
            exit();
        } else {
            $usernameErr = "Email or username already exists";
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

    <h1>Register</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        Email: <input type="email" name="email" value="<?php echo $email; ?>" autocomplete=on required>
        <span class=error>* <?php echo $emailErr; ?></span>

        <br><br>

        Username: <input type="text" name=username value="<?php echo $username ?>" autocomplete=off required>
        <span class=error>* <?php echo $usernameErr; ?></span>
        <br><br>

        Password: <input type="password" name="password" autocomplete=off required>
        <span class=error>* <?php echo $passwordErr; ?></span>
        <br><br>

        Confirm Password: <input type="password" name="cpassword" required>
        <span class=error>* <?php echo $cpasswordErr; ?></span>
        <br><br>

        <input type="submit" value="Register">
    </form><br>
    <form action="login.php">
        <input type="submit" value="Login">
    </form>
</body>

</html>