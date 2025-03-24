<?php

include 'db.php';

$username = $_POST['username'];

$sql = "DELETE from users WHERE username = '$username'";

if (mysqli_query($conn, $sql)) {  

    echo "Record deleted successfully";

} else {

    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>