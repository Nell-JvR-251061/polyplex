<?php //Logs user out by resetting the session storage
session_start();

$_SESSION = [];

session_destroy();

header('Location: ../index.php');

exit;
?>