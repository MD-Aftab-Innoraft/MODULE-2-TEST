<?php

// Requiring the autoload file.
require('./vendor/autoload.php');

//  Used to load environment variables from a .env file into
// our PHP application using the Dotenv library.It helps in managing
// configuration settings, database credentials, API keys, and other
// sensitive information in a secure and convenient way.
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Establishing connection with MySQL.
$mysqli = new mysqli(
  hostname: $_ENV['DB_HOST'],
  username: $_ENV['DB_USER'],
  password: $_ENV['DB_PASS'],
  database: $_ENV['DB_DATABASE']
);

// If an error occurs during connection.
if ($mysqli->connect_errno) {
  die("Connection error: " . $mysqli->connect_error);
}

// Returning the connection object.
return $mysqli;
