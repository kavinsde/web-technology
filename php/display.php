<?php

session_start();

// Display submission message if exists
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
echo "<br><a href='./index.php'>Go to form</a>";

