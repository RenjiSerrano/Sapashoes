<?php
include_once "../once_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];

    // Perform the update in the database
    $updateQuery = "UPDATE orders SET order_status = '$newStatus' WHERE orders_id = '$orderId'";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>
