<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product to Brand</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/adminCSS.css">
    <link rel="stylesheet" href="css/addCustomize.css">

    <header class="header">

   <div class="flex">

      <a href="#" class="logo">Once</a>

      <nav class="navbar">
         <a href="admin_page.php">Home</a>
         <a href="add_products.php">Add products</a>
         <a href="#">Customize Product</a>
         <a href="viewCustomer.php">Customer</a>
         <a href="viewAllOrders.php">Sales</a>
         <a href="logout.php" class="logout">logout</a>
      </nav>


   </div>

</header>

  

</head>
<body>

<?php
// Include the database connection file
include_once 'onceu_db.php';

// Process form data on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["add_brand"])) {
    $brandName = $_POST["brand_name"] ?? '';
    $brandPrice = $_POST["brand_price"] ?? 0; // Set a default value if needed

    // Insert new brand into the 'brand' table
    $stmt = $db->prepare("INSERT INTO brand (brand, brand_price) VALUES (:brand, :brand_price)");
    $stmt->bindParam(':brand', $brandName);
    $stmt->bindParam(':brand_price', $brandPrice);
    $stmt->execute();

    // Provide feedback or perform any necessary actions after successful insertion
    echo "<p>New brand '$brandName' added successfully with price: $brandPrice</p>";
} elseif(isset($_POST["add_colorway"])) {
        $colorwayName = $_POST["colorway_name"] ?? '';
        $colorwayPrice = $_POST["colorway_price"] ?? 0; // Set a default value if needed
    
        // Insert new brand into the 'brand' table
        $stmt = $db->prepare("INSERT INTO colorway (colorway, colorway_price) VALUES (:colorway, :colorway_price)");
        $stmt->bindParam(':colorway', $colorwayName);
        $stmt->bindParam(':colorway_price', $colorwayPrice);
        $stmt->execute();

        echo "<p>New colorway '$colorwayName' added successfully with price: $colorwayPrice</p>";
    } elseif(isset($_POST["add_customization"])) {
        $customizationName = $_POST["customization_name"] ?? '';
        $customizationPrice = $_POST["customization_price"] ?? 0; // Set a default value if needed
    
        // Insert new brand into the 'brand' table
        $stmt = $db->prepare("INSERT INTO customization (customization, customization_price) VALUES (:customization, :customization_price)");
        $stmt->bindParam(':customization', $customizationName);
        $stmt->bindParam(':customization_price', $customizationPrice);
        $stmt->execute();

        echo "<p>New Design '$customizationName' added successfully with price: $customizationPrice</p>";
    } elseif(isset($_POST["add_sizes"])) {
        $sizesName = $_POST["sizes_name"] ?? '';

        // Insert new size into the 'sizes' table
        $stmt = $db->prepare("INSERT INTO sizes (sizes) VALUES (:sizes)");
        $stmt->bindParam(':sizes', $sizesName);
        $stmt->execute();

        // Provide feedback or perform any necessary actions after successful insertion
        echo "<p>New Size '$sizesName' added successfully!</p>";
    }

}
?>
<div>

<h2>Add Brand</h2>
    <form method="post" action="">
     <label for="brand_name">Brand Name:</label>
        <input type="text" name="brand_name" id="brand_name" required>
        <label for="brand_price">Price:</label>
        <input type="number" step="0.01" name="brand_price" id="brand_price" required>
            <button type="submit" name="add_brand" >Add Brand</button>
    </form>

</div>
<div>
    <!-- Colorway Section -->
<h2>Add Colorway</h2>
    <form method="post" action="">
        <label for="colorway_name">Colorway Name:</label>
        <input type="text" name="colorway_name" id="colorway_name" required>
        <label for="colorway_price">Price:</label>
        <input type="number" step="0.01" name="colorway_price" id="colorway_price" required>
            <button type="submit" name="add_colorway">Add Colorway</button>
    </form>
</div>

<div>
    <!-- Customization Section -->
    <h2>Add Customization</h2>
    <form method="post" action="">
    <label for="customization_name">Design Name:</label>
        <input type="text" name="customization_name" id="customization_name" required>
        <label for="customization_price">Price:</label>
        <input type="number" step="0.01" name="customization_price" id="customization_price" required>
        <button type="submit" name="add_customization">Add Customization</button>
    </form>
</div>

<div>
    <!-- Sizes Section -->
    <h2>Add Sizes</h2>
    <form method="post" action="">
        <label for="sizes_name">Size:</label>
        <input type="number" min="34", max="47" name="sizes_name" id="sizes_name" required>
        <button type="submit" name="add_sizes">Add Size</button>
    </form>
</div>

</body>
</html>
