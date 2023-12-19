<?php
// Include the database connection file
@include 'once_db.php';

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

function generateTrackingNumber() {
    // Function to generate a random tracking number
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $tracking_number = '';
    $length = 10;

    for ($i = 0; $i < $length; $i++) {
        $tracking_number .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $tracking_number;
}

if (isset($_POST['order_btn'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $method = $_POST['method'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];

    // Retrieve logged-in user ID
    $user_id = $_SESSION['user_id'];

    // Fetch cart items and calculate total price
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart_customize`");
    $price_total = 0;
    $product_name = [];
    $grand_total = 0; // Initialize grand total

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['brand'] . ' (' . $product_item['colorway'] . ') (' . $product_item['customization'] . ') (' . $product_item['quantity'] . ')';
            $price_total += $product_item['price'] * $product_item['quantity'];
        }

        $total_product = implode(', ', $product_name);

        // Generate a unique tracking number
        $tracking_number = generateTrackingNumber();

        // Insert order details into the database along with user ID
        $detail_query = mysqli_query($conn, "INSERT INTO `customize_orders` (user_id, tracking_number, name, phone_number, method, province, city, barangay, street, total_products, total_price) 
        VALUES ('$user_id', '$tracking_number', '$name', '$phone_number', '$method', '$province', '$city', '$barangay', '$street', '$total_product', '$price_total')");

        if ($detail_query) {
            // Display order confirmation message
            echo "
            <div class='order-message-container'>
                <!-- Your order confirmation details here -->
                <h3>Thank you for shopping!</h3>
                <p>Your tracking number: <strong>$tracking_number</strong></p>
                <p>Order details:</p>
                <div class='order-detail'>
                    <span>$total_product</span>
                    <span class='total'>Total: ₱$price_total</span>
                </div>
                <div class='customer-details'>
                    <p>Your name: <span>$name</span></p>
                    <p>Your number: <span>$phone_number</span></p>
                    <p>Your address: <span>$province, $city, $barangay, $street</span></p>
                    <p>Your payment mode: <span>$method</span></p>
                    <p>(*Pay when product arrives*)</p>
                </div>
                <a href='products.php' class='btn'>Continue shopping</a>
            </div>
            ";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<div class='display-order'><span>Your cart is empty!</span></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/userCSS.css">
   <title>checkout</title>
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
                <a href="logout.php" class="logout">logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <section class="checkout-form">
            <h1 class="heading">Complete your order</h1>
            <form action="customizeOrderDetails.php" method="post">
                <div class="display-order">
                    <?php
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart_customize` ORDER BY customize_id DESC LIMIT 1");

                    if (mysqli_num_rows($select_cart) > 0) {
                        $fetch_cart = mysqli_fetch_assoc($select_cart);
                        $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
                        $grand_total = $total_price; // Calculate grand total
                    
                        ?>
                        <span><?= $fetch_cart['brand']; ?> (<?= $fetch_cart['colorway']; ?>) (<?= $fetch_cart['customization']; ?>) (<?= $fetch_cart['quantity']; ?>)</span>
                    <?php
                    } else {
                        echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                    }
                    ?>
                    <span class="grand-total">Total: ₱<?= $grand_total; ?></span>
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>Your name</span>
                        <input type="text" placeholder="Enter your Name" name="name" required>
                    </div>
                    <div class="inputBox">
                        <span>Phone number</span>
                        <input type="number" placeholder="Phone Number" name="phone_number" required>
                    </div>
                    <div class="inputBox">
                        <span>Payment method</span>
                        <select name="method">
                            <option value="cash on delivery" selected>Cash on Delivery</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>Province</span>
                        <input type="text" placeholder="Province" name="province" required>
                    </div>
                    <div class="inputBox">
                        <span>City</span>
                        <input type="text" placeholder="City" name="city" required>
                    </div>
                    <div class="inputBox">
                        <span>Barangay</span>
                        <input type="text" placeholder="Barangay" name="barangay" required>
                    </div>
                    <div class="inputBox">
                        <span>Street</span>
                        <input type="text" placeholder="Street Name, Building, House No." name="street" required>
                    </div>
                </div>
                <input type="submit" value="Order Now" name="order_btn" class="btn">
            </form>
        </section>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
