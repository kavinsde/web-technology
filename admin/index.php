<?php

session_start();

if (isset($_SESSION["username"])) {
    echo "Welcome " . $_SESSION["username"];
    echo "<br><a href='logout.php'>Logout</a>";
} else {
    header("Location: login.php");
}
