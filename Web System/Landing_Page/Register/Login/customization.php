<?php

session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Include the database connection file
include_once 'onceu_db.php';

// Process form data on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process data from each step
    $step1Data = $_POST["brand"] ?? '';
    $step2Data = $_POST["colorway"] ?? '';
    $step3Data = $_POST["customization"] ?? '';
    $step4Data = $_POST["sizes"] ?? '';
    $product_quantity = 1; // Assuming a default quantity of 1

    $brandPriceQuery = $db->prepare("SELECT brand_price FROM brand WHERE brand = :brand");
    $brandPriceQuery->bindParam(':brand', $step1Data);
    $brandPriceQuery->execute();
    $brandPrice = $brandPriceQuery->fetchColumn();

    $colorwayPriceQuery = $db->prepare("SELECT colorway_price FROM colorway WHERE colorway = :colorway");
    $colorwayPriceQuery->bindParam(':colorway', $step2Data);
    $colorwayPriceQuery->execute();
    $colorwayPrice = $colorwayPriceQuery->fetchColumn();

    $customizationPriceQuery = $db->prepare("SELECT customization_price FROM customization WHERE customization = :customization");
    $customizationPriceQuery->bindParam(':customization', $step3Data);
    $customizationPriceQuery->execute();
    $customizationPrice = $customizationPriceQuery->fetchColumn();

    // Calculate total price
    $totalPrice = $brandPrice + $colorwayPrice + $customizationPrice;

    // Get the logged-in user ID
    $userId = $_SESSION['user_id'];

    // Prepare and execute the query to store customization details along with the user ID
    $stmt = $db->prepare("INSERT INTO cart_customize (user_id, brand, colorway, customization, sizes, quantity, price) VALUES (:userId, :brand, :colorway, :customization, :sizes, :quantity, :totalPrice)");
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':brand', $step1Data);
    $stmt->bindParam(':colorway', $step2Data);
    $stmt->bindParam(':customization', $step3Data);
    $stmt->bindParam(':sizes', $step4Data);
    $stmt->bindParam(':quantity', $product_quantity);
    $stmt->bindParam(':totalPrice', $totalPrice);
    
    $stmt->execute();

    // Store data in session variables
    $_SESSION['customization_summary'] = [
        'brand' => $step1Data,
        'colorway' => $step2Data,
        'customization' => $step3Data,
        'sizes' => $step4Data,
        'totalPrice' => $totalPrice // Optionally store total price in session
    ];

    // Redirect to another page to display the summary
    header("Location: customizeDetails.php");
    exit(); // Stop further execution
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/customization.css">
    <link rel="stylesheet" href="css/userCSS.css">
    <title>Product Customization</title>
    <header class="header">

<div class="flex">

   <a href="#" class="logo">Once</a>

   <nav class="navbar">
      <a href="user_page.php">Home</a>
      <a href="products.php">Products</a>
      <a href="#">Customize</a>
      <a href="cart.php">Cart</a>
      <a href="orderHistory.php">Orders</a>
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
    // Process data from each step
    $step1Data = $_POST["brand"] ?? '';
    $step2Data = $_POST["colorway"] ?? '';
    $step3Data = $_POST["customization"] ?? '';
    $step4Data = $_POST["sizes"] ?? '';
    $product_quantity = 1;

    // Fetch prices for brand, colorway, and customization
    $brandPriceQuery = $db->prepare("SELECT brand_price FROM brand WHERE brand = :brand");
    $brandPriceQuery->bindParam(':brand', $step1Data);
    $brandPriceQuery->execute();
    $brandPrice = $brandPriceQuery->fetchColumn();

    $colorwayPriceQuery = $db->prepare("SELECT colorway_price FROM colorway WHERE colorway = :colorway");
    $colorwayPriceQuery->bindParam(':colorway', $step2Data);
    $colorwayPriceQuery->execute();
    $colorwayPrice = $colorwayPriceQuery->fetchColumn();

    $customizationPriceQuery = $db->prepare("SELECT customization_price FROM customization WHERE customization = :customization");
    $customizationPriceQuery->bindParam(':customization', $step3Data);
    $customizationPriceQuery->execute();
    $customizationPrice = $customizationPriceQuery->fetchColumn();

    // Calculate total price
    $totalPrice = $brandPrice + $colorwayPrice + $customizationPrice;

    // Get the logged-in user ID
    $userId = $_SESSION['user_id'];

    // Prepare and execute the query to store customization details along with the user ID
    $stmt = $db->prepare("INSERT INTO cart_customize (user_id, brand, colorway, customization, sizes, quantity, price) VALUES (:userId, :brand, :colorway, :customization, :sizes, :quantity, :totalPrice)");
$stmt->bindParam(':userId', $userId);
$stmt->bindParam(':brand', $step1Data);
$stmt->bindParam(':colorway', $step2Data);
$stmt->bindParam(':customization', $step3Data);
$stmt->bindParam(':sizes', $step4Data);
$stmt->bindParam(':quantity', $product_quantity);
$stmt->bindParam(':totalPrice', $totalPrice);

$stmt->execute();

    

    // Store data in session variables
    $_SESSION['customization_summary'] = [
        'brand' => $step1Data,
        'colorway' => $step2Data,
        'customization' => $step3Data,
        'sizes' => $step4Data,
        'totalPrice' => $totalPrice // Optionally store total price in session
    ];

    // Redirect to another page to display the summary
    header("Location: customizeDetails.php");
    exit(); // Stop further execution

    echo "<option value='" . $row['brand'] . "' data-price='" . $row['price'] . "'>" . $row['brand'] . " - $" . $row['price'] . "</option>";
}
?>


<form id="customizationForm" method="post" action="">
<div id="brand" class="step">
    <h2>Step 1: Choose Brand</h2>
    <select name="brand">
        <?php
        // Assuming $db is your database connection
        $query = $db->query("SELECT DISTINCT brand FROM brand");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['brand'] . "'>" . $row['brand'] . "</option>";
        }
        ?>
    </select>
</div>

<div id="colorway" class="step">
    <h2>Step 2: Choose Colorway</h2>
    <select name="colorway">
        <?php
        // Assuming $db is your database connection
        $query = $db->query("SELECT DISTINCT colorway FROM colorway");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['colorway'] . "'>" . $row['colorway'] . "</option>";
        }
        ?>
    </select>
</div>


    <div id="customization" class="step">
    <h2>Step 3: Choose Design</h2>
    <select name="customization">
        <?php
        // Assuming $db is your database connection
        $query = $db->query("SELECT DISTINCT customization FROM customization");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['customization'] . "'>" . $row['customization'] . "</option>";
        }
        ?>
    </select>
</div>

    <div id="sizes" class="step">
    <h2>Step 4: Choose Size</h2>
    <select name="sizes">
        <?php
        // Assuming $db is your database connection
        $query = $db->query("SELECT DISTINCT sizes FROM sizes");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['sizes'] . "'>" . $row['sizes'] . "</option>";
        }
        ?>
       
    </select>
    <button type="submit">Submit</button>
</div>

<div id="totalPrice"></div>

</form>

<script>
    function nextStep(stepId) {
        var currentStep = document.getElementById(stepId);
        currentStep.style.display = "none";

        var nextStep = document.getElementById(stepId.substr(0, 5) + (parseInt(stepId.charAt(5)) + 1));
        if (nextStep) {
            nextStep.style.display = "block";
        } else {
            document.getElementById("customizationForm").submit();
        }
    }
</script>


<script src="js/customize.js"></script>

</body>
</html>