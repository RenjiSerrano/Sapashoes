<?php
@include 'once_db.php';

$sqlOrders = "SELECT * FROM orders";
$resultOrders = $conn->query($sqlOrders);

$sqlProducts = "SELECT * FROM products";
$resultProducts = $conn->query($sqlProducts);

$totalPaidSales = 0; // Initializing total paid sales variable
?>

<!-- Your HTML code -->

<div id="ordersBtn">
    <h2>Order Details</h2>
    <table class="table table-striped">
        <!-- Table headers -->
        <thead>
            <tr>
                <!-- Header columns -->
                <th>ID</th>
                <th>Product Name</th>
                <th>Order Date</th>
                <th>Total Pay</th>
                <th>Shipping Info</th>
            </tr>
        </thead>
        <tbody>
            <!-- Fetching and displaying orders -->
            <?php
            if ($resultOrders->num_rows > 0) {
                while ($row = $resultOrders->fetch_assoc()) {
                    // Fetching product details based on order
                    $productId = $row['id']; // Assuming 'product_id' column in orders table
            
                    // Fetch product details from products table
                    $sqlProductDetails = "SELECT id, name FROM products WHERE id = $productId";
                    $resultProductDetails = $conn->query($sqlProductDetails);
            
                    if ($resultProductDetails && $resultProductDetails->num_rows > 0) {
                        $productDetails = $resultProductDetails->fetch_assoc();
                        if ($productDetails) {
                            ?>
                            <tr>
                                <!-- Display order and product details -->
                                <td><?= $productDetails["id"] ?></td>
                                <td><?= $productDetails["name"] ?></td>
                                <td><?= $row["order_date"] ?></td>
                                <td>₱<?= $row["total_price"] ?></td>
                                <!-- ... (rest of your code remains the same) ... -->
                            </tr>
                            <?php
                        }
                    }
                    // Ensure to release the product details query result
                    $resultProductDetails->free_result();
                }
            }
            ?>
        </tbody>
    </table>

</div>

<!-- JavaScript section remains unchanged -->
