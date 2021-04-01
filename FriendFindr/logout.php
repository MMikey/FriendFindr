<?php

//initalise the session
session_start();

// unset all of the session variables
//sets session to a blank array
$_SESSION = array();

//ends the session on the user browser
session_destroy();

//redirect to login page
header("location: login.php");
exit;
?>
