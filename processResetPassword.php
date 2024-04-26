<?php

// Keeps track whether the password was successfully reset.
$resetSuccess = false;

// Getting token value and generating its hash.
$token = $_POST["token"];
$token_hash = hash("sha256", $token);

// Requiring the database connection file.
$mysqli = require __DIR__ . "/database.php";

// SQL prepared statement to get row with matching token hash.
$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// None of the token hashes match.
if ($user == NULL) {
  die("Token not found!");
}

// Token expiration time is crossed.
if (strtotime($user["reset_token_expires_at"]) <= time()) {
  die("Token has expired!");
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

// Setting new password, assigning NULL to token and its expiration.
$sql = "UPDATE user
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user["id"]);
$stmt->execute();

// Password has been reset successfully.
$resetSuccess = true;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Success</title>
</head>

<body>
  <?php if ($resetSuccess) : ?>
    <p>Password updated. You can now <a href="login.php">login</a></p>
  <?php else : ?>
    <p>Password resetting failed. <a href="login.php">Go back</a> </p>
  <?php endif; ?>
</body>

</html>
