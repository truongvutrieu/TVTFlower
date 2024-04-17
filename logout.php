<?php

// Include config file if needed
@include 'config.php';

// Start session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header('location: login.php');
exit(); // Exit after redirection to prevent further execution
?>
