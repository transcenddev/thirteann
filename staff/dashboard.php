<?php
    // Checks if the user is a staff
    require "../config/staff-authentication.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThirTeaAnn</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/dashboard.css">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/staff-sidebar.css">
    <?php include('../config/config.php'); ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
    <!-- Sidebar Navigator -->
    <?php require "../config/staff-sidebar.php"; ?>

    <div class="main-content">
        <h1 class="title">Dashboard</h1>

        <div class="card-container">
            <div class="card">
                <div class="card-title">
                    <p>Most Popular</p>
                    <img src="../assets/dashboard_assets/trophy.svg" alt="Trophy">
                </div>
                <hr>

                <!-- Get Most Popular Product -->
                <?php 
                    $result = $mysqli->query("SELECT product_name, SUM(quantity) as total_quantity FROM order_items GROUP BY product_name ORDER BY total_quantity DESC LIMIT 1;");

                    if ($result && $row = $result->fetch_assoc()) {
                        $productName = $row['product_name'];
                        echo "<h2>$productName</h2>";
                    } else {
                        echo "<p>No data found or error: " . $mysqli->error . "</p>";
                    }

                    $result->free();
                ?>
            </div>

            <div class="card">
                <div class="card-title">
                    <p>Orders</p>
                    <img src="../assets/dashboard_assets/orders.svg" alt="Orders">
                </div>
                <hr>

                <!-- Get Count of All Orders -->                
                <?php 
                    $result = $mysqli->query("SELECT COUNT(*) AS total_orders FROM order_table;");

                    if ($result && $row = $result->fetch_assoc()) {
                        $totalOrders = $row['total_orders'];
                        echo "<h2>$totalOrders</h2>";
                    } else {
                        echo "<p>No data found or error: " . $mysqli->error . "</p>";
                    }

                    $result->free();
                ?>
            </div>

            <div class="card">
                <div class="card-title">
                    <p>Sales</p>
                    <img src="../assets/dashboard_assets/trophy.svg" alt="Trophy">
                </div>
                <hr>

                <!-- Get Sum of All Total Prices -->
                <?php 
                    $result = $mysqli->query("SELECT SUM(total_price) AS total_sales FROM order_table;");

                    if ($result && $row = $result->fetch_assoc()) {
                        $totalSales = $row['total_sales'];
                        echo "<h2>$totalSales</h2>";
                    } else {
                        echo "<p>No data found or error: " . $mysqli->error . "</p>";
                    }

                    $result->free();
                ?>
            </div>

        </div>

        <div class="table-section">
            <table class="table" id="recent_orders">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Query All Orders and Populate to Table-->
                    <?php
                        require '../config/config.php';

                        $stmt = $mysqli->prepare("SELECT order_id, date, total_price FROM order_table");
                        $stmt->execute();
                        $stmt->bind_result($order_id, $date, $total_price);

                        // Initialize an array to store the results
                        $orderResults = [];

                        while ($stmt->fetch()) {
                            // Store each row in the array
                            $orderResults[] = [
                                'order_id' => $order_id,
                                'date' => $date,
                                'total_price' => $total_price,
                            ];
                        }

                        // Close the statement
                        $stmt->close();

                        $stmt = $mysqli->prepare("SELECT order_id, product_name FROM order_items");
                        $stmt->execute();
                        $stmt->bind_result($order_id, $product_name);

                        $orderItems = [];

                        while ($stmt->fetch()) {
                            $orderItems[] = [
                                'order_id' => $order_id,
                                'product_name' => $product_name,
                            ];
                        }

                        // Echo the results into the table using a different while loop
                        foreach ($orderResults as $order) {
                            echo "<tr>";
                            echo "<td>{$order['order_id']}</td>";
                            echo "<td>{$order['date']}</td>";
                            echo "<td>";
                            foreach ($orderItems as $orderItem) {
                                if ($orderItem['order_id'] == $order['order_id']) {
                                    echo "{$orderItem['product_name']} <br>";
                                }
                            }
                            echo "</td>";
                            echo "<td>{$order['total_price']}</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Change table to DataTable of jQuery
        function initializeDataTable() {
            $('#recent_orders').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
            });
        }

        $(document).ready(function () {
            initializeDataTable();
        });
    </script>


<?php $mysqli->close(); ?>
</body>
</html>