<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Starting the session.
session_start();

// Unsetting the session variables.
session_unset();
// Destroying the session.
session_destroy();

// Redirecting to the home page.
header("location: index.php");
exit;

