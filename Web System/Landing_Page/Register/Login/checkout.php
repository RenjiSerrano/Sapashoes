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
    // Retrieve form data
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $method = $_POST['method'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];

    // Fetch cart items
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
    $grand_total = 0;
    $cart_items = [];

    if(mysqli_num_rows($select_cart) > 0){
        while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $item_total = $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total += $item_total;

            // Store cart items for display
            $cart_items[] = [
                'name' => $fetch_cart['name'],
                'quantity' => $fetch_cart['quantity'],
                'total_price' => $item_total,
            ];
        }
    }

    $total_product = implode(', ', array_column($cart_items, 'name'));

    // Generate a unique tracking number
    $tracking_number = generateTrackingNumber();

    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'];

    // Insert order details including user ID
    $detail_query = mysqli_query($conn, "INSERT INTO `orders` (tracking_number, user_id, name, phone_number, method, province, city, barangay, street, total_products, total_price) 
                    VALUES ('$tracking_number', '$user_id', '$name', '$phone_number', '$method', '$province', '$city', '$barangay', '$street', '$total_product', '$grand_total')") or die('query failed');

    if ($detail_query) {
        // Redirect to order details with the generated tracking number in the URL
        header("Location: order_details.php?tracking_number=$tracking_number");
        exit();
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

   <header class="header">

<div class="flex">

   <a href="#" class="logo">Once</a>

   <nav class="navbar">
      <a href="user_page.php">Home</a>
      <a href="products.php">Products</a>
      <a href="customization.php">Customize</a>
      <a href="cart.php">Cart</a>
      <a href="logout.php" class="logout">logout</a>
   </nav>


</div>

</header>

 

</head>
<body>


<div class="container">

<section class="checkout-form">

   <h1 class="heading">complete your order</h1>

   <form action="checkout.php" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $fetch_cart['price'] * $fetch_cart['quantity'];
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> total : ₱<?= $grand_total; ?> </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>your name</span>
            <input type="text" placeholder="Enter your Name" name="name" required>
         </div>
         <div class="inputBox">
            <span>phone number</span>
            <input type="number" placeholder="Phone Number" name="phone_number" required>
         </div>
         
         <div class="inputBox">
            <span>payment method</span>
            <select name="method">
               <option value="cash on delivery" selected>Cash on Devlivery</option>
            </select>
         </div>
         <div class="inputBox">
            <span>province</span>
            <input type="text" placeholder="Province" name="province" required>
         </div>
         
         <div class="inputBox">
            <span>city</span>
            <input type="text" placeholder="City" name="city" required>
         </div>
         
         <div class="inputBox">
            <span>barangay</span>
            <input type="text" placeholder="Barangay" name="barangay" required>
         </div>

         <div class="inputBox">
            <span>Street</span>
            <input type="text" placeholder="Street Name, Building, House No." name="street" required>
         </div>
         
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>