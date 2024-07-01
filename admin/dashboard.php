    <?php
        // Checks if the user is an admin
        require "../config/admin-authentication.php";
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
        <link rel="stylesheet" href="../styles/admin-sidebar.css">
        <?php include('../config/config.php'); ?>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <!-- Sidebar Navigator -->
        <?php require "../config/admin-sidebar.php"; ?>

        <div class="main-content">
            <h1 class="title">Dashboard</h1>

            <div class="card-container">
                <div class="card">
                    <div class="card-title">
                        <p>Most Popular</p>
                        <i class='bx bx-trophy nav__icon'></i>
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
                        <i class='bx bx-wallet nav__icon'></i>
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
                        <i class='bx bx-money-withdraw nav__icon' ></i>
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

            <div class="sales-overview">
                <h4>Sales by Date</h4>
                <canvas id="SalesByDate"></canvas>
            </div>

            <div class="wrapper">
                <table class="table" id="recent_orders">
                
                    <!-- <caption>Recent Orders</caption> -->
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
                                echo "<td data-cell='Order ID'>{$order['order_id']}</td>";
                                echo "<td data-cell='Date'>{$order['date']}</td>";
                                echo "<td data-cell='Product'>";
                                foreach ($orderItems as $orderItem) {
                                    if ($orderItem['order_id'] == $order['order_id']) {
                                        echo "{$orderItem['product_name']} <br>";
                                    }
                                }
                                echo "</td>";
                                echo "<td data-cell='Price'>{$order['total_price']}</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Data for Sales by Date -->
        <?php 
                    $result = $mysqli->query("SELECT date, SUM(total_price) AS total_sales_date FROM order_table GROUP BY date ORDER BY date;");

                    if ($result) {
                        $dates = array();
                        $totalsales_date = array();

                        while ($row = $result->fetch_assoc()) {
                            $dates[] = $row['date'];
                            $totalsales_date[] = $row['total_sales_date'];
                        }
                        $result->free();
                    } else {
                        echo "<p>No data found or error: " . $mysqli->error . "</p>";
                    }
                ?>

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


            // Chart for Sales by Date
            <!-- line chart for Sales by Date -->
            const ctx = document.getElementById('SalesByDate');
            const dates = <?php echo json_encode($dates); ?>;
            const totalsales_date = <?php echo json_encode($totalsales_date); ?>;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Sales by Date',
                        data: totalsales_date,
                        borderWidth: 1,
                        backgroundColor: 'rgba(0, 222, 163, 0.2)', // Background color
                        borderColor: 'rgba(0, 222, 163, 1)' // Border color
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false, 
                            }
                        }
                    }
                }
            });
        </script>
    
    <?php $mysqli->close(); ?>
    </body>
    </html>