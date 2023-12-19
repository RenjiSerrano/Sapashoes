<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture buyer information from the form
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';

    // You can capture additional fields here

    // Access the customized product details from the session
    if (isset($_SESSION['customization_summary'])) {
        $summary = $_SESSION['customization_summary'];
        // Process the order with the captured details

        // For demonstration, let's output the captured data
        echo "<h2>Order Summary:</h2>";
        echo "<p>Buyer Name: $name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Address: $address</p>";

        echo "<h2>Customized Product Details:</h2>";
        echo "<p>Customize Name: {$summary['brand']} ({$summary['colorway']}) {$summary['customization']}</p>";
        echo "<p>Size: {$summary['sizes']}</p>";

        // Perform further actions (e.g., save to a database, send confirmation email, etc.)
        // Implement your logic here for processing the order

        // Clear the customization details from the session after processing the order
        unset($_SESSION['customization_summary']);
    } else {
        echo "No customization data found.";
    }
} else {
    // Redirect if accessed without a POST request (form submission)
    header("Location: checkoutCustomize.php");
    exit();
}
?>
