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

/**
 * Class to establish connection between PHP and MySQL
 * and work with the database.
 */
class DbConnect
{

  /**
   * @var object $conn
   *  Stores an instance of PDO class.
   */
  private $conn;

  /**
   * Method to create and return an isntance of PDO establishing connection
   * with the MySQL database for carrying out operations on database.
   */
  function dbcon()
  {
    // Trying to establish a connection with MySQL database.
    try {
      $this->conn = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" .
        $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
      $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    catch (Exception $e) {
      echo "Connection could not be established." . $e->getMessage() . $e->getCode();
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    // Returning the connection object.
    return $this->conn;
  }
}

// Creating an object of DbConnect class.
$connection = new DbConnect();
// Creating a PDO connection object using DbConnect's method.
$conn = $connection->dbcon();
