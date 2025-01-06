<?php

$number = 12345;
$n = (string) $number;

$sum = 0;
$remainder = 0;

for ($i = 0; $i < strlen($number); $i++) {
    $remainder = (int) $number % 10;
    $number = $number / 10;

    $sum += $remainder;
}

echo "Sum of digits of {$n} is {$sum}.";
