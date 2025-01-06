<?php
function factorial($number) {
    if ($number < 0) {
        return "Invalid input";
    }
    if ($number == 0) {
        return 1;
    }
    $factorial = 1;
    for ($i = 1; $i <= $number; $i++) {
        $factorial *= $i;
    }
    return $factorial;
}

$number = 5;
echo "Factorial of $number is " . factorial($number);
?>