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


    <?php
include_once 'onceu_db.php';

function fetchPrice($db, $columnName, $selectedValue)
{
    $query = $db->prepare("SELECT {$columnName}_price FROM {$columnName} WHERE {$columnName} = :selected_value");
    $query->bindParam(':selected_value', $selectedValue);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

if (isset($_SESSION['customization_summary'])) {
    $summary = $_SESSION['customization_summary'];

    // Retrieve user ID from the session
    $user_id = $_SESSION['user_id'];

    echo "<h2>Customization Details:</h2>";
    echo "<p>Customize Name: {$summary['brand']} ({$summary['colorway']}) {$summary['customization']}</p>";
    echo "<p>Size: {$summary['sizes']}</p>";

    $totalPrice = 0;

    // Fetch brand price
    $brandResult = fetchPrice($db, 'brand', $summary['brand']);
    if ($brandResult && isset($brandResult['brand_price'])) {
        $totalPrice += $brandResult['brand_price'];
    }

    // Fetch colorway price
    $colorwayResult = fetchPrice($db, 'colorway', $summary['colorway']);
    if ($colorwayResult && isset($colorwayResult['colorway_price'])) {
        $totalPrice += $colorwayResult['colorway_price'];
    }

    // Fetch customization price
    $customizationResult = fetchPrice($db, 'customization', $summary['customization']);
    if ($customizationResult && isset($customizationResult['customization_price'])) {
        $totalPrice += $customizationResult['customization_price'];
    }

    // ... (similar calculations for other customization details if needed)

    echo "<h2>Total Price:</h2>";
    echo "<p id='totalPriceDisplay'>₱" . number_format($totalPrice, 2) . "</p>";
?>
<input type="submit" value="Place Order" class="btn" onclick="location.href='checkoutCustomize.php';">
    <button onclick="location.href='customization.php';">Return to Customize</button>
    <?php

    unset($_SESSION['customization_summary']);
} else {
    echo "No customization data found.";
}
?>

<script>
    // Initial total price value from PHP
    let totalPrice = <?php echo $totalPrice; ?>;

    // Function to update total price based on quantity
    function updateTotalPrice(quantity) {
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const newTotalPrice = quantity * totalPrice;
        totalPriceDisplay.textContent = '₱' + newTotalPrice.toFixed(2);
    }

    // Event listener for quantity input changes
    const quantityInput = document.getElementById('quantity'); // Assuming there's an input field with id 'quantity'
    quantityInput.addEventListener('input', function() {
        const quantity = parseInt(this.value) || 0; // Ensure a valid number

        // Update the total price
        updateTotalPrice(quantity);
    });

    // Initial display of total price based on default quantity value
    updateTotalPrice(parseInt(quantityInput.value) || 1);
</script>
</body>
</html>