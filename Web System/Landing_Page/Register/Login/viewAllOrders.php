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
         <a href="viewCustomer.php">Customer</a>
         <a href="#">Sales</a>
         <a href="logout.php" class="logout">logout</a>
      </nav>

   </div>
</header>

<div id="ordersBtn">
    <h2>Order Details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tracking No.</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Order Status</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlOrders = "SELECT * FROM orders";
            $resultOrders = $conn->query($sqlOrders);

            $sqlCustomizeOrders = "SELECT * FROM customize_orders";
            $resultCustomizeOrders = $conn->query($sqlCustomizeOrders);

            $totalPaidSales = 0;

            if ($resultOrders->num_rows > 0) {
                while ($row = $resultOrders->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $row["orders_id"] ?></td>
                        <td><?= $row["tracking_number"] ?></td>
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["phone_number"] ?></td>
                        <td><?= $row["order_date"] ?></td>
                        <td>₱<?= $row["total_price"] ?></td>
                        <td><?= $row["method"] ?></td>
                        <td>
                            <?php if ($row["order_status"] == 0): ?>
                                <button class="btn btn-danger change-order-status"
                                        onclick="ChangeOrderStatus('<?= $row['orders_id'] ?>', 1)">Pending</button>
                            <?php else: ?>
                                <button class="btn btn-success change-order-status"
                                        onclick="ChangeOrderStatus('<?= $row['orders_id'] ?>', 0)">Delivered</button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row["payment_status"] == 0): ?>
                                <button class="btn btn-danger change-payment-status"
                                        onclick="ChangePaymentStatus('<?= $row['orders_id'] ?>', 1)">Unpaid</button>
                            <?php else: ?>
                                <button class="btn btn-success change-payment-status"
                                        onclick="ChangePaymentStatus('<?= $row['orders_id'] ?>', 0)">Paid</button>
                                <?php
                                $totalPaidSales += $row["total_price"];
                                ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                }
            }

            if ($resultCustomizeOrders->num_rows > 0) {
                while ($row = $resultCustomizeOrders->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $row["customize_id"] ?></td>
                        <td><?= $row["tracking_number"] ?></td>
                        <td><?= $row["brand"] . '(' . $row["colorway"] . ') ' . $row["customization"] ?></td>
                        <td><?= $row["phone_number"] ?></td>
                        <td><?= $row["order_date"] ?></td>
                        <td>₱<?= $row["total_price"] ?></td>
                        <td><?= $row["method"] ?></td>
                        <td>
                            <?php if ($row["order_status"] == 0): ?>
                                <button class="btn btn-danger change-order-status"
                                        onclick="ChangeOrderStatus('<?= $row['customize_id'] ?>', 1)">Pending</button>
                            <?php else: ?>
                                <button class="btn btn-success change-order-status"
                                        onclick="ChangeOrderStatus('<?= $row['customize_id'] ?>', 0)">Delivered</button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row["payment_status"] == 0): ?>
                                <button class="btn btn-danger change-payment-status"
                                        onclick="ChangePaymentStatus('<?= $row['customize_id'] ?>', 1)">Unpaid</button>
                            <?php else: ?>
                                <button class="btn btn-success change-payment-status"
                                        onclick="ChangePaymentStatus('<?= $row['customize_id'] ?>', 0)">Paid</button>
                                <?php
                                $totalPaidSales += $row["total_price"];
                                ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <p class="total-sales">Total Sales: ₱<?= $totalPaidSales ?></p> 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function ChangeOrderStatus(orderId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'updateOrderStatus.php',
            data: {
                order_id: orderId,
                new_status: newStatus
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function ChangePaymentStatus(orderId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'updatePayStatus.php',
            data: {
                order_id: orderId,
                new_status: newStatus
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function ChangeOrderStatus(orderId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'updateOrder_status.php',
            data: {
                customize_id: orderId,
                new_status: newStatus
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function ChangePaymentStatus(orderId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'updatePay.php',
            data: {
                customize_id: orderId,
                new_status: newStatus
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

</body>
</html>
