<?php

@include 'once_db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Once Admin Page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/adminCSS.css">
</head>
<body>

<header class="header">
   <div class="flex">
      <a href="#" class="logo">Once</a>

      <nav class="navbar">
         <a href="admin_page.php">Home</a>
         <a href="add_products.php">Add products</a>
         <a href="addCustomize.php">Customize Product</a>
         <a href="#">Customer</a>
         <a href="viewAllOrders.php">Sales</a>
         <a href="logout.php" class="logout">logout</a>
      </nav>

   </div>
</header>

<div >
<p class="client">Customers</p>
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Name </th>
        <th class="text-center">Email</th>
        <th class="text-center">User Type</th>
      </tr>
    </thead>
    <?php
      
      $sql="SELECT * from user where user_type=0";
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td class="text-center"><?=$count?></td>
      <td class="text-center"><?=$row["name"]?> </td>
      <td class="text-center"><?=$row["email"]?></td>
      <td class="text-center"><?=$row["user_type"]?></td>
      
    </tr>
    <?php
            $count=$count+1;
           
        }
    }
    ?>
  </table>