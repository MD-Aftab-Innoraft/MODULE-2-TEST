<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <link rel="stylesheet" href="./CSS/body.css">
</head>

<body>
  <h1>Forgot Password</h1>
  <form action="./sendPasswordReset.php" method="post">
    <!-- Email id to send recovery mail to(if exists in DB). -->
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required maxlength="75">

    <!-- Submit button for form. -->
    <button>Send</button>

    <!-- Go back to index. -->
    <p class="font-18 my-8"><a href="index.php">Login / Signup</a></p>
  </form>
</body>

</html>
