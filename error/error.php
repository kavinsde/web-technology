<html>
<head>
<title>Beginning PHP6, Apache, MySQL Web Development Custom Error Page</title>
</head>
<body>
<?php
switch ($_SERVER['QUERY_STRING']) {
case 400:
    echo '<h1>Bad Request</h1>';
    echo '<h2>Error Code 400</h2>';
    echo '<p>The browser has made a Bad Request.</p>';
    break;
case 401:
    echo '<h1>Authorization Required</h1>';
    echo '<h2>Error Code 401</h2>';
    echo '<p>You have supplied the wrong information to access a secure resource.</p>';
    break;
case 403:
    echo '<h1>Access Forbidden</h1>';
    echo '<h2>Error Code 403</h2>';
    echo '<p>You have been denied access to this resource.</p>';
    break;
case 404:
    echo '<h1>Page Not Found</h1>';
    echo '<h2>Error Code 404</h2>';
    echo '<p>The page you are looking for cannot be found.</p>';
    break;
case 500:
    echo '<h1>Internal Server Error</h1>';
    echo '<h2>Error Code 500</h2>';
    echo '<p>The server has encountered an internal error.</p>';
    break;
default:
    echo '<h1>Error Page</h1>';
    echo '<p>This is a custom error page...</p>';
}
echo '<p><a href="mailto:sysadmin@example.com">Contact</a> the system administrator if you feel this to be in error.</p>';

$now = (isset($_SERVER['REQUEST_TIME'])) ? $_SERVER['REQUEST_TIME'] : time();
$page = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : 'unknown';
$msg = wordwrap('A ' . $_SERVER['QUERY_STRING'] . ' error was encountered on ' .
date('F d, Y', $now) . ' at ' . date('H:i:sa T', $now) . ' when a ' .
'visitor attempted to view ' . $page . '.');
mail('admin@example.com', 'Error from Website', $msg);
?>
</body>
</html>


<!-- 

400: Bad Request
401: Authorization Required
403: Forbidden
404: Not Found
500: Internal Server Error

More: http://rfc.net/rfc2616.html#p57

Apache’ s ErrorDocument Directive
In httpd.conf file:

ErrorDocument 400 /error.php?400
ErrorDocument 401 /error.php?401
ErrorDocument 403 /error.php?403
ErrorDocument 404 /error.php?404
ErrorDocument 500 /error.php?500
-->