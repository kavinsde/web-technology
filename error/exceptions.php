<?php
// $x = null;
// $x = 500;
$x = 1000;

try {
    if (is_null($x)) {
        throw new Exception('Value cannot be null.');
    }
    if ($x < 1000) {
        throw new Exception('Value cannot be less than 1000.');
    }
    echo 'Value passed validation.';
}
catch (Exception $e) {
    echo 'Validation failed. ' . $e->getMessage();
}
?>
