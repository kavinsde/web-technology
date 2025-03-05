<form method="POST">
    <input type="submit" name="submit" value="Submit">
</form>

<?php
if ($_POST['submit'] == 'Submit') {
    // form has been submitted
    echo 'In the if statement';
} else {
    // form has not been submitted
    echo 'Form has not been submitted';
}
?>
