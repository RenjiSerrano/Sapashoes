<?php include('once_db.php') ?>
<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?msg=no_user_found");
    exit(); // Ensure to stop further execution
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/adminCSS.css">
   <link rel="stylesheet" href="css/adminlte.min.css">
   <title>Once Admin Page</title>

   <header class="header">

   <div class="flex">

      <a href="#" class="logo">Once</a>

      <nav class="navbar">
         <a href="#.php">Home</a>
         <a href="add_products.php">Add Products</a>
         <a href="addCustomize.php">Customize Product</a>
         <a href="viewCustomer.php">Customer</a>
         <a href="viewAllOrders.php">Sales</a>
         <a href="logout.php" class="logout">logout</a>
      </nav>

   </div>

</header>
<div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM products")->num_rows; ?></h3>

                <p>Total Products</p>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM user")->num_rows; ?></h3>

                <p>Total Users</p>
              </div>
              
            </div>
          </div>
       </div>

       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM orders")->num_rows; ?></h3>

                <p>Total Orders</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
       </div>
       
       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php 
                $result = $conn->query("SELECT * FROM orders WHERE order_status='1'");
                echo $result->num_rows; 
                ?></h3>

                <p>Total Delivered</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php 
                $sql = "SELECT * FROM orders WHERE order_status='0'";
                $result = $conn->query($sql);
                echo $result->num_rows; 
                ?></h3>

                <p>Pending</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
       </div>

       <div class="row">
    <div class="col-md-3">
        <div class="small-box bg-light shadow-sm border">
            <div class="inner">
                <?php
                
                $result = $conn->query("SELECT * FROM orders WHERE payment_status = '1'");
                $totalPaidOrders = $result->num_rows;

                
                $totalPaidSales = 0;
                while ($row = $result->fetch_assoc()) {
                    $totalPaidSales += $row["total_price"];
                }
                ?>
                <h3>₱<?= $totalPaidSales ?></h3>
                <p>Total Sales: </p>
            </div>
            <div class="icon">
                <i class="fa fa-building"></i>
            </div>
        </div>
    </div>
</div>

         

</head>
<body>
