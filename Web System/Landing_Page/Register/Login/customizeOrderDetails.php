<?php
@include 'once_db.php';

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
   <link rel="stylesheet" href="css/orderDetails.css">
   <title>checkout</title>

   <header class="header">

<div class="flex">

   <a href="#" class="logo">Once</a>

   <nav class="navbar">
      <a href="user_page.php">Home</a>
      <a href="products.php">Products</a>
      <a href="customization.php">Customize</a>
      <a href="cart.php">Cart</a>
      <a href="orderHistory.php">Orders</a>
      <a href="logout.php" class="logout">logout</a>
   </nav>


</div>

</header>

 

</head>
<body>

<?php
// Include database connection file
include_once 'once_db.php';

// Function to generate a random tracking number
function generateTrackingNumber() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $tracking_number = '';
    $length = 10; 

    for ($i = 0; $i < $length; $i++) {
        $tracking_number .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $tracking_number;
}

if (isset($_POST['order_btn'])) {
    // Retrieve logged-in user ID
    $user_id = $_SESSION['user_id'];

    // Fetch the latest row from cart_customize table
    $latest_cart_query = mysqli_query($conn, "SELECT * FROM `cart_customize` ORDER BY customize_id DESC LIMIT 1");

    // Check if the query returned any row
    if (mysqli_num_rows($latest_cart_query) > 0) {
        $product_item = mysqli_fetch_assoc($latest_cart_query);

        // Access the latest row's data
        $product_name = $product_item['brand'] . ' (' . $product_item['colorway'] . ') (' . $product_item['customization'] . ') (' . $product_item['quantity'] . ')';
        $price_total = $product_item['price'] * $product_item['quantity'];

        // Extract additional details
        $brand = $product_item['brand'];
        $colorway = $product_item['colorway'];
        $customization = $product_item['customization'];
        $sizes = $product_item['sizes'];

        // Retrieve other form data
        $name = $_POST['name'];
        $phone_number = $_POST['phone_number'];
        $method = $_POST['method'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $barangay = $_POST['barangay'];
        $street = $_POST['street'];

        // Generate a unique tracking number
        $tracking_number = generateTrackingNumber();

        // Insert order details into the database including brand, colorway, customization, sizes, and user ID
        $detail_query = mysqli_query($conn, "INSERT INTO `customize_orders` (user_id, tracking_number, name, phone_number, method, province, city, barangay, street, total_products, total_price, brand, colorway, customization, sizes) 
                        VALUES ('$user_id', '$tracking_number', '$name', '$phone_number', '$method', '$province', '$city', '$barangay', '$street', '$product_name', '$price_total', '$brand', '$colorway', '$customization', '$sizes')") or die('query failed');

if ($detail_query) {
    // Display order confirmation message with details
    echo "
    <div class='order-message-container'>
        <div class='message-container'>
            <h1>Your Order Details</h1>
            <p>Tracking Number: $tracking_number</p>
            <p>Items: $product_name</p>
            <p>Size: $sizes</p>
            <p>Total Price: $price_total</p>
            <h2>Your Information</h1>
            <p>Name: $name</p>
            <p>Your Payment Method: $method</p>
            <!-- Add more details as needed -->
        </div>
    </div>
    ";
}
    }
}
?>
</body>
</html>