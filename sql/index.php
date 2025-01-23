<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mails</title>
    <style>.error { color: red; }</style>
</head>
<body>

    <?php

        $email    = $message    = "";
        $emailErr = $messageErr = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include "db.php";

            $email = test_input($_POST["email"]);

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }

            $message = test_input($_POST["message"]);

            if (strlen($message) < 10) {
                $messageErr = "Message must be at least 10 characters";
            } else if (strlen($message) > 250) {
                $messageErr = "Message must be less than 250 characters";
            }

            if ($emailErr == "" && $messageErr == "") {

                $stmt = $connection->prepare("INSERT INTO mails (email, message) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $message);

                $stmt->execute();

                $stmt->close();

                header("Location: index.php");
                exit();
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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <span class="error">*<?php echo $emailErr; ?></span>
        <br><br>

        <label for="message">Message:</label><br><br>
        <textarea id="message" name="message" rows="4" cols="50" required><?php echo $message; ?></textarea>
        <span class="error">*<?php echo $messageErr; ?></span>
        <br><br>

        <input type="submit" value="Submit">
    </form>

</body>
</html>