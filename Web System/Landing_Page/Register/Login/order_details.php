<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/userCSS.css"> <!-- Make sure to link your custom CSS -->
   <title>Order Details</title>
   <style>
      /* Add any additional styles for the table here */
      table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 20px;
      }
      th, td {
         border: 1px solid #ddd;
         padding: 8px;
         text-align: left;
      }
      th {
         background-color: #f2f2f2;
      }
   </style>
</head>
<body>

<header class="header">
    <div class="flex">
        <a href="#" class="logo">Once</a>
        <nav class="navbar">
            <a href="user_page.php">Home</a>
            <a href="products.php">Products</a>
            <a href="customization.php">Customize</a>
            <a href="cart.php">Cart</a>
            <a href="orderHistory.php">Orders</a>
            <a href="logout.php" class="logout">Logout</a>
        </nav>
    </div>
</header>

<?php
include_once 'once_db.php';

if (isset($_GET['tracking_number'])) {
    $tracking_number = $_GET['tracking_number'];

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE tracking_number = '$tracking_number'");

    if ($order_query && mysqli_num_rows($order_query) > 0) {
        $order_details = mysqli_fetch_assoc($order_query);

        // Display fetched order details in a table
        echo "<div class='order-details-container'>
                  <h1>Order Details</h1>
                  <table>
                      <tr>
                          <th>Details</th>
                          <th>Information</th>
                      </tr>
                      <tr>
                          <td>Tracking Number</td>
                          <td>{$order_details['tracking_number']}</td>
                      </tr>
                      <tr>
                          <td>Name</td>
                          <td>{$order_details['name']}</td>
                      </tr>
                      <!-- Add other order details in a similar structure -->
                      <tr>
                          <td>Total Products</td>
                          <td>{$order_details['total_products']}</td>
                      </tr>
                      <tr>
                          <td>Total Price</td>
                          <td>₱{$order_details['total_price']}</td>
                      </tr>
                  </table>
                  <!-- Additional content can go here -->
              </div>";
    } else {
        echo "<p>No order found with the provided tracking number.</p>";
    }
} else {
    echo "<p>Tracking number not found!</p>";
}
?>

<!-- Your additional HTML content goes here -->

</body>
</html>
