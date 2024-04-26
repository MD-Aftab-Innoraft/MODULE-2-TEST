<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

// Keeps track whether signup was successful or not.
$signupSuccess = false;

// Name field is empty.
if (empty($_POST["name"])) {
  die("Name is required");
}

// Invalid email address.
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
  die("Valid email is required");
}

// Password isn't atleast 8 characters long.
if (strlen($_POST["password"]) < 8) {
  die("Password must be 8 characters long.");
}

// Password does not contain atleast 1 alphabet.
if (!preg_match("/[a-z]/i", $_POST["password"])) {
  die("Password must contain at least one letter");
}

// Password does not contain atleast 1 digit.
if (!preg_match("/[0-9]/", $_POST["password"])) {
  die("Password must contain at least one number");
}

// Password and Confirm-passwords do not match.
if ($_POST["password"] !== $_POST["cPassword"]) {
  die("Passwords must match");
}

// Hashing the password.
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Requiring the database connection file.
$mysqli = require __DIR__ . "/database.php";

// Prepared sql statement for adding an entry(new user) to the DB.
$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?,?,?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
  die("SQL Error: " . $mysqli->error);
}
$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

// Try to insert the record in the DB.
try {
  if ($stmt->execute()) {
    header("location: signupSuccess.html");
    exit;
  }
} catch (Exception $e) {
  if ($mysqli->errno === 1062) {
    die("Email already taken");
  } else {
    die($mysqli->error . " " . $mysqli->errno);
  }
}

// User data successfully added to DB.
$signupSuccess = true;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup status</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
  <?php if ($signupSuccess) : ?>
    <p>Sign up successfull. You can now <a href="login.php">login</a></p>
  <?php else : ?>
    <p>Cannot sign you up at the moment. <a href="index.php">Go back</a></p>
  <?php endif; ?>
</body>

</html>
