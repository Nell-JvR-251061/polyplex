<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'polyplex';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
// }else{ used to check if connection took place
//     echo '10-4 Good Buddy';
// }

$conn->set_charset('utf8mb4');

