<?php
include_once "../once_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['customize_id'];
    $newStatus = $_POST['new_status'];

    // Perform the update in the database
    $updateQuery = "UPDATE customize_orders SET order_status = '$newStatus' WHERE customize_id = '$orderId'";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>
