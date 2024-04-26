<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Starting session even before login.
session_start();

// Variable to know whether a record was successfully added.
$successfulEntry = FALSE;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $stockName = $_POST["stockName"];
  $stockPrice = $_POST["stockPrice"];

  // Requiring the database connection file.
  $mysqli = require __DIR__ . "/database.php";

  // Prepared sql statement for adding an entry(new user) to the DB.
  $sql = "INSERT INTO Stock (stock_name, stock_price, user_id)
        VALUES (?,?,?)";
  $stmt = $mysqli->stmt_init();
  if (!$stmt->prepare($sql)) {
    die("SQL Error: " . $mysqli->error);
  }
  $stmt->bind_param("sdi", $stockName, $stockPrice, $_SESSION["userId"]);

  // Try to insert the record in the DB.
  try {
    if ($stmt->execute()) {
      $successfulEntry = TRUE;
      header("location: stock-entry.php");
      exit;
    }
  } catch (Exception $e) {
    die($mysqli->error . " " . $mysqli->errno);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Entry</title>
  <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
  <!-- Navbar. -->
  <div class="navbar">
    <a class="active" href="/index.php">Home</a>
    <a href="/stock-entry.php">Add a Stock</a>
    <a href="#services">Services</a>
    <a href="/logout.php">Logout</a>
  </div>
  <div class="container">
    <!-- Logout Button. -->
    <p class="logoutBtn"><a href="logout.php">Logout</a></p>
    <?php
    global $successfulEntry;
    if ($successfulEntry) :
      echo $stockName . " added successfully";
    endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="heading text-center">Add a Stock</div>
      <!-- Input the stock name. -->
      <div>
        <label for="stockName">Stock Name:</label>
        <input type="text" name="stockName" id="stockName" required minlength="2" maxlength="70">
      </div>

      <!-- Input the stock price. -->
      <div>
        <label for="stockPrice">Stock Price:</label>
        <input type="text" name="stockPrice" id="stockPrice" required pattern="^\d*(\.\d{0,2})?$">
      </div>

      <!-- Submit button for form. -->
      <button id="addStockBtn" class="font-16 my-16">Add Stock</button>

    </form>

    <h2 class="font-22 font-black text-center">Stocks you added:</h2>
    <div class="table-wrapper">
      <table class="fl-table">
        <thead>
          <tr>
            <th>Stock Name</th>
            <th>Stock Price</th>
            <th>Created Date</th>
            <th>Last updated</th>
            <th>Action</th>
          </tr>

        </thead>
        <tbody>
          <?php foreach ($stocks as $stock) { ?>
            <tr>
              <td><?php echo $stock[1] ?></td>
              <td><?php echo $stock[2]; ?></td>
              <td><?php echo $stock[3]; ?></td>
              <td><?php echo $stock[4]; ?></td>
              <td><?php if ($stock[5] == $_SESSION['user_id']) : ?>
                  <button id="deleteStockBtn">Delete Stock</button>
                <?php else :
                    echo "No action";
                  endif; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>
