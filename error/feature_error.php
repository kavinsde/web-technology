<?php
// Create your error handler function
function my_error_handler($e_type, $e_message, $e_file, $e_line) {
    $msg = 'Errors have occurred while executing a page.' . "\n\n";
    $msg .= 'Error Type: ' . $e_type . "\n";
    $msg .= 'Error Message: ' . $e_message . "\n";
    $msg .= 'Filename: ' . $e_file . "\n";
    $msg .= 'Line Number: ' . $e_line . "\n"; // Corrected to $e_line
    $msg = wordwrap($msg, 75); // Wrap message at 75 characters

    switch($e_type) { // Corrected to use $e_type
        case E_ERROR:
            mail('admin@example.com', 'Fatal Error from Website', $msg);
            die();
            break;
        case E_WARNING:
            mail('admin@example.com', 'Warning from Website', $msg);
            break;
    }
}

// Set error handling to 0 because we will handle all error reporting
// and notify admin on warnings and fatal errors.
error_reporting(0);

// Set the error handler to be used
set_error_handler('my_error_handler');

// Set string with "Wrox" spelled wrong
$string_variable = 'Worx books are awesome!';

// Try to use str_replace to replace 'Worx' with 'Wrox' 
// This will generate an E_WARNING because of wrong parameter count
str_replace('Worx', 'Wrox');  // Missing the third argument to trigger the warning

// Create the rest of your page here.
?>
