<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Include database connection file
include_once 'once_db.php';

// Fetch orders for the logged-in user from orders table
$user_id = $_SESSION['user_id'];
$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY order_date DESC");

// Fetch customize orders for the logged-in user from customize_orders table
$customize_query = mysqli_query($conn, "SELECT * FROM `customize_orders` WHERE user_id = '$user_id' ORDER BY order_date DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/userCSS.css">
    <link rel="stylesheet" href="css/tableStyles.css"> 
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
            <a href="#">Orders</a>
            <a href="logout.php" class="logout">logout</a>
        </nav>
    </div>
</header>

<div class="order-history-container">
    <h1>Order History</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Tracking Number</th>
                <th>Items</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
if ($order_query && $customize_query) {
    if (mysqli_num_rows($order_query) == 0 && mysqli_num_rows($customize_query) == 0) {
        echo "<tr><td colspan='5'>No orders found in the history.</td></tr>";
    } else {
        // Loop through and display regular orders
        if (mysqli_num_rows($order_query) > 0) {
            while ($order_details = mysqli_fetch_assoc($order_query)) {
                echo "
                <tr>
                    <td>{$order_details['orders_id']}</td>
                    <td>{$order_details['tracking_number']}</td>
                    <td>{$order_details['total_products']}</td>
                    <td>₱{$order_details['total_price']}</td>
                    <td>{$order_details['order_date']}</td>
                </tr>
                ";
            }
        }
        
        // Loop through and display customize orders
        if (mysqli_num_rows($customize_query) > 0) {
            while ($customize_details = mysqli_fetch_assoc($customize_query)) {
                echo "
                <tr>
                    <td>{$customize_details['customize_id']}</td>
                    <td>{$customize_details['tracking_number']}</td>
                    <td>{$customize_details['total_products']}</td>
                    <td>₱{$customize_details['total_price']}</td>
                    <td>{$customize_details['order_date']}</td>
                </tr>
                ";
            }
        }
    }
} else {
    echo "Error executing order queries: " . mysqli_error($conn);
}
?>

        </tbody>
    </table>
</div>
</body>
</html>