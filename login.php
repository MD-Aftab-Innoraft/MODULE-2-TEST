<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Starting the session.
session_start();
// Keeps track if username of password is invalid.
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Requiring the database connection file.
  $mysqli = require __DIR__ . "/database.php";

  // SQL prepared statement to check whether input email is present in the DB.
  $sql = sprintf(
    "SELECT * FROM user
                  WHERE email = '%s'",
    $mysqli->real_escape_string($_POST["email"])
  );

  // Executing the query and fetching result(user details) as associative array.
  $result = $mysqli->query($sql);
  $user = $result->fetch_assoc();

  // User exists in the database.
  if ($user) {
    // Verifying the input password and stored password hash.
    if (password_verify($_POST["password"], $user["password_hash"])) {
      // Start session if password is correct.
      session_start();

      // Regenerate session id to avoid session fixation attack.
      session_regenerate_id();

      // Adding id of user as session variable and redirecting to index page.
      $_SESSION["user_id"] = $user["id"];
      header("location: /index.php");
    }
  }

  // Username/password is invalid.
  $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
  <h1>Login</h1>

  <!-- If username/password is invalid, we display a relevant message. -->
  <?php if ($is_invalid) : ?>
    <em style="color:red">Invalid credentials!</em>
  <?php endif; ?>

  <!-- Login form. -->
  <form method="post">
    <!-- Email id of the user. -->
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_POST["email"] ?? ""); ?>">

    <!-- Password for the user account. -->
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">

    <!-- Submit button for form. -->
    <button>Log in</button>
  </form>
  <!-- Link forgot password page if user forgets/wishes to reset password. -->
  <p class="my-8"><a href="./forgotPassword.php">Forgot password?</a></p>
  <!-- Register page if user wishes to register. -->
  <p class="font-18 my-16">Don't have an account? <a href="./signup.html">Signup</a></p>
</body>

</html>
