<!DOCTYPE html>
<html>
<body>
    <form action="index.php" method="POST">
        <p>Name: <input type="text" name="name" autocomplete=off></p>
        <p>Bio: <textarea name="bio"></textarea></p>
        <input type="hidden" name="timestamp" value="<?php echo time(); ?>">
        <p>Password: <input type="password" name="password"></p>

        <p>Country:
            <select name="country">
                <option value="not selected">Select</option>
                <option value="usa">USA</option>
                <option value="uk">UK</option>
                <option value="india">India</option>
            </select>
        </p>

        <p>Gender:
            <input type="radio" name="gender" value="male"> Male
            <input type="radio" name="gender" value="female"> Female
        </p>

        <p>Interests:
            <input type="checkbox" name="interests[]" value="sports"> Sports
            <input type="checkbox" name="interests[]" value="reading"> Reading
        </p>

        <input type="submit" value="Submit">
    </form>

    <?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['message'] = "<h2>Form Submission Results:</h2>";
    $_SESSION['message'] .= "Name: " . htmlspecialchars($_POST['name']) . "<br>";
    $_SESSION['message'] .= "Bio: " . htmlspecialchars($_POST['bio']) . "<br>";
    $_SESSION['message'] .= "Timestamp: " . htmlspecialchars($_POST['timestamp']) . "<br>";
    $_SESSION['message'] .= "Password: " . htmlspecialchars($_POST['password']) . "<br>";
    $_SESSION['message'] .= "Country: " . htmlspecialchars($_POST['country']) . "<br>";
    $_SESSION['message'] .= "Gender: " . (isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : "Not selected") . "<br>";
    $_SESSION['message'] .= "Interests: ";

    if (isset($_POST['interests'])) {
        $_SESSION['message'] .= implode(", ", array_map('htmlspecialchars', $_POST['interests']));
    } else {
        $_SESSION['message'] .= "None selected";
    }

    header("Location: display.php");
    exit();
}
?>
</body>
</html>