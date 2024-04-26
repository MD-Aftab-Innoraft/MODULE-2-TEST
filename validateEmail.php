<?php

// Requiring the database connection file.
$mysqli = require __DIR__ . "/database.php";

// Query to check if email already exists in DB.
$sql = sprintf(
  "SELECT * FROM user
                WHERE email = '%s'",
  $mysqli->real_escape_string($_GET["email"])
);
$result = $mysqli->query($sql);

// If no email matches in DB, the email is available.
$is_available = $result->num_rows === 0;

// Setting the response header and sending a JSON response.
header("Content-Type: application/json");
echo json_encode(["email" => $_GET['email'], "available" => $is_available]);
