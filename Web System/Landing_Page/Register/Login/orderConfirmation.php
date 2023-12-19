<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <!-- Your CSS and other necessary links -->
</head>
<body>
    <h1>Order Confirmation</h1>
    <h2>Order Summary:</h2>
    <?php
    include_once 'customizeDetails.php'; // Include the customizeDetails.php file to get the customization details and total price

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $zipcode = $_POST['zipcode'];

        echo "<p>Name: $fullname</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Address: $address, $city, $zipcode</p>";
        echo "<p>Customize Name: $customizeName</p>"; // Display Customize Name fetched from customizeDetails.php
        echo "<p>Total Price: ₱" . number_format($totalPrice, 2) . "</p>"; // Display Total Price fetched from customizeDetails.php
        // Display other order details if needed
    } else {
        echo "No data received.";
    }
    ?>
</body>
</html>
