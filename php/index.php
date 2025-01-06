<!-- form.html -->
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
                <option value="">Select</option>
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
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Form Submission Results:</h2>";
    echo "Name: " . htmlspecialchars($_POST['name']) . "<br>";
    echo "Bio: " . htmlspecialchars($_POST['bio']) . "<br>";
    echo "Timestamp: " . htmlspecialchars($_POST['timestamp']) . "<br>";
    echo "Password: " . htmlspecialchars($_POST['password']) . "<br>";
    echo "Country: " . htmlspecialchars($_POST['country']) . "<br>";
    echo "Gender: " . (isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : "Not selected") . "<br>";

    echo "Interests: ";
    if (isset($_POST['interests'])) {
        echo implode(", ", array_map('htmlspecialchars', $_POST['interests']));
    } else {
        echo "None selected";
    }
}
?>