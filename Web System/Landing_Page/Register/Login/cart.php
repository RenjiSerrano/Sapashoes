<?php

@include 'once_db.php';

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}


   if(isset($_POST['update_update_btn'])){
      $update_value = $_POST['update_quantity'];
      $update_id = $_POST['update_quantity_id'];
      $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE cart_id = '$update_id'");
      if($update_quantity_query){
         header('location:cart.php');
      };
   };

   if(isset($_GET['remove'])){
      $remove_id = $_GET['remove'];
      mysqli_query($conn, "DELETE FROM `cart` WHERE cart_id = '$remove_id'");
      header('location:cart.php');
   };

   if(isset($_GET['delete_all'])){
      mysqli_query($conn, "DELETE FROM `cart`");
      header('location:cart.php');
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

         <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
            <th>action</th>
         </thead>

         <tbody>

            <?php 
            
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
            $grand_total = 0;
            if(mysqli_num_rows($select_cart) > 0){
               while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            ?>

            <tr>
               <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
               <td><?php echo $fetch_cart['name']; ?></td>
               <td>₱<?php echo number_format($fetch_cart['price']); ?></td>
               <td>
                  <form action="" method="post">
                     <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['cart_id']; ?>" >
                     <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
                     <input type="submit" value="update" name="update_update_btn">
                  </form>   
               </td>
               <td>₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
               <td><a href="cart.php?remove=<?php echo $fetch_cart['cart_id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
            </tr>
            <?php
            $grand_total += $fetch_cart['price'] * $fetch_cart['quantity'];
               };
            };
            ?>
            <tr class="table-bottom">
               <td><a href="products.php" class="option-btn" style="margin-block-start: 0;">continue shopping</a></td>
               <td colspan="3">grand total</td>
               <td>₱<?php echo number_format($grand_total); ?></td>
               <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
               
            </tr>

         </tbody>

      </table>

      <div class="checkout-btn">
         <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
      </div>

   </section>

   </div>
      

   </body>
   </html>