<?php

// Extracting value of token from $_GET.
$token = $_GET["token"];
// Hashing the token.
$token_hash = hash("sha256", $token);

// Requiring the database connection file.
$mysqli = require __DIR__ . "/database.php";

// Selecting row from table where the token hashes match.
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

// Token has expired.
if (strtotime($user["reset_token_expires_at"]) <= time()) {
  die("Token has expired!");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <link rel="stylesheet" href="./CSS/body.css">
</head>

<body>
  <h1>Reset Password</h1>
  <!-- Form to reset password. -->
  <form action="processResetPassword.php" method="post">
    <!-- Hidden input field to store token. -->
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

    <!-- Input for new password. -->
    <label for="password">New password:</label>
    <input type="password" name="password" id="password">

    <!-- Input to confirm new password. -->
    <label for="cPassword">Confirm password:</label>
    <input type="password" name="cPassword" id="cPassword">

    <!-- Submit button for form. -->
    <button>Reset Password</button>
  </form>
</body>

</html>
