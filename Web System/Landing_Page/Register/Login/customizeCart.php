<?php

@include 'once_db.php';

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = $db->prepare("UPDATE `cart_customize` SET quantity = :update_value WHERE customize_id = :update_id");
    $update_quantity_query->bindParam(':update_value', $update_value);
    $update_quantity_query->bindParam(':update_id', $update_id);
    $update_quantity_query->execute();
    header('Location: customizeCart.php');
    exit();
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $remove_query = $db->prepare("DELETE FROM `cart_customize` WHERE customize_id = :remove_id");
    $remove_query->bindParam(':remove_id', $remove_id);
    $remove_query->execute();
    header('Location: customizeCart.php');
    exit();
}

if (isset($_GET['delete_all'])) {
    $delete_all_query = $db->query("DELETE FROM `cart_customize`");
    header('Location: customizeCart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Once Cart</title>

   <header class="header">

<div class="flex">

   <a href="#" class="logo">Once</a>

   <nav class="navbar">
      <a href="user_page.php">Home</a>
      <a href="products.php">Products</a>
      <a href="customization.php">Customize</a>
      <a href="#">Cart</a>
      <a href="orderHistory.php">Orders</a>
      <a href="logout.php" class="logout">logout</a>
   </nav>


</div>

</header>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/userCSS.css">

</head>
<body>


<div class="container">
      <section class="shopping-cart">
         <h1 class="heading">shopping cart</h1>
         <table>
            <!-- Existing table headers -->
            <tbody>
               <?php
               $select_cart = $db->query("SELECT * FROM `cart_customize`");
               $grand_total = 0;
               if ($select_cart->rowCount() > 0) {
                  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               ?>
                     <tr>
                        <!-- Display customized product details -->
                        <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['brand'] . ' (' . $fetch_cart['colorway'] . ') ' . $fetch_cart['customization']; ?></td>
                        <td>₱<?php echo number_format($fetch_cart['price']); ?></td>
                        <td>
                           <form action="" method="post">
                              <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['customize_id']; ?>">
                              <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                              <input type="submit" value="update" name="update_update_btn">
                           </form>
                        </td>
                        <td>₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                        <td><a href="cart.php?remove=<?php echo $fetch_cart['customize_id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
                     </tr>
               <?php
                     $grand_total += $fetch_cart['price'] * $fetch_cart['quantity'];
                  };
               };
               ?>
               <!-- Existing table bottom content -->
            </tbody>
         </table>
         <!-- Existing checkout button section -->
      </section>
   </div>

   

</body>
</html>