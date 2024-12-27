<html>
    <head>
        <title>Odd or Even</title>
    </head>
    <body>
        <?php 
        $content = "Odd or Even";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $number = $_POST["number"];
            if (!is_numeric($number)) {
                $content = "Please enter a valid number.";
            } else if ($number % 2 == 0) {
                $content = "The number {$number} is even.";
            } else {
                $content = "The number {$number} is odd.";
            }   
        }
        ?>
        <h1><?php echo $content ?></h1>
        <form action="oddOrEven.php" method="post">
            Enter a Number: 
            <input type="number" name=number>
            <input type="submit" value="Check">
        </form>
    </body>
</html>