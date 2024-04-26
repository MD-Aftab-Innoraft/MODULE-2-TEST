<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Starting session even before login.
session_start();


// If user_id is set.
if (isset($_SESSION["user_id"])) {
  $userID = $_SESSION["user_id"];
  // Requiring the database connection file.
  $mysqli = require __DIR__ . "/database.php";

  // Getting the data of the user from the DB.
  // $sql = "SELECT * FROM user
  //         WHERE id = $userID";
  // $result = $mysqli->query($sql);
  // $user = $result->fetch_assoc();

  $getStockListSql = "SELECT * FROM Stock";
  $stockResult = $mysqli->query($getStockListSql);
  $stocks = $stockResult->fetch_all();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="./CSS/style.css">
  <link rel="stylesheet" href="CSS/index.css">
</head>

<body>

  <!-- If user is logged in, he is showed the home page. -->
  <?php if (isset($user)) : ?>
    <!-- Navbar. -->
    <div class="navbar">
      <a class="active" href="/index.php">StockKeeper - Home</a>
      <a href="/stock-entry.php">Add a Stock</a>
      <a href="#services">Services</a>
      <a href="/logout.php">Logout</a>
    </div>
    <div class="container">
      <h2 class="font-22 font-black text-center">STOCK TABLE</h2>
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
                <td><?php if($stock[5] == $_SESSION['user_id']): ?>
                  <button id="deleteStockBtn">Delete Stock</button>
                  <?php else:
                    echo "No action";
                   endif; ?>
              </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- Button to redirect to stock entry page. -->
      <p class="font-18 my-16">Add a stock <a href="./stock-entry.php">here</a></p>
    </div>
    <!-- If user isn't logged in, he is given the option to signup/login. -->
  <?php else :
    header("location: /login.php"); #}
  endif;
  ?>
  <!-- Linking the script files. -->
  <script src="./JS/formValidate.js"></script>
</body>

</html>
