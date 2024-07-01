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
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="../styles/order-records.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="modalBodyContent">
                    <h4 class="mb-0 text-center">ThirTeaAnn</h4>
                    <p class="text-center">Timalan Balsahan<br> Naic, Cavite</p>
                    <p id="currentDate"></p>
                    <div id="order_information">
                        <!-- Order information will be displayed here -->
                    </div>
                </div>

                <!-- button to print the modal-body exactly as what it looks like the size and information -->
                <div class="modal-footer p-1 m-auto">
                    <button type="button" class="btn" onclick="printModalBody()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigator -->
    <?php require "../config/staff-sidebar.php"; ?>

    <div class="main-content-staff">
        <h1>Order History</h1>

        <div class="table-section">
            <table class="table" id="orderHistory_table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total Price</th>
                        <th>Payment</th>
                        <th>Change</th>
                        <th>Payment Method</th>
                        <th>Receipt ID</th>
                        <th>Receipt</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Get All Orders and Order Items and Populate it to table -->
                    <?php
                        require '../config/config.php';

                        $stmt = $mysqli->prepare("SELECT * FROM order_table");
                        $stmt->execute();
                        $stmt->bind_result($order_id, $date, $receipt_id, $total_price, $payment_received, $exact_change, $payment_method);

                        // Initialize an array to store the results
                        $orderResults = [];

                        while ($stmt->fetch()) {
                            // Store each row in the array
                            $orderResults[] = [
                                'order_id' => $order_id,
                                'date' => $date,
                                'receipt_id' => $receipt_id,
                                'total_price' => $total_price,
                                'payment_received' => $payment_received,
                                'exact_change' => $exact_change,
                                'payment_method' => $payment_method
                            ];
                        }

                        // Close the statement
                        $stmt->close();

                        $stmt = $mysqli->prepare("SELECT * FROM order_items");
                        $stmt->execute();
                        $stmt->bind_result($order_item_id, $order_id, $product_id, $product_name, $size, $price, $quantity, $total_price);

                        $orderItems = [];

                        while ($stmt->fetch()) {
                            $orderItems[] = [
                                'order_id' => $order_id,
                                'product_id' => $product_id,
                                'product_name' => $product_name,
                                'size' => $size,
                                'quantity' => $quantity,
                                'total_price' => $total_price,
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
                                    echo "{$orderItem['product_name']} ({$orderItem['size']}) - Quantity: {$orderItem['quantity']} - Total Price: {$orderItem['total_price']}<br>";
                                }
                            }
                            echo "</td>";
                            echo "<td>{$order['total_price']}</td>";
                            echo "<td>{$order['payment_received']}</td>";
                            echo "<td>{$order['exact_change']}</td>";
                            echo "<td>{$order['payment_method']}</td>";
                            echo "<td>{$order['receipt_id']}</td>";
                            echo "<td>
                                    <button class='btn'
                                            data-order-id='{$order['order_id']}'
                                            id='receiptBtn'>
                                        Receipt
                                    </button>
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>

        // Change table to DataTable of jQuery
        function initializeDataTable() {
            $('#orderHistory_table').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
                order: [[0, 'desc']]
            });
        }

        $(document).ready(function () {
            initializeDataTable();
        });

        // When the receipt button is clicked, get the order ID and display the order information
        $(document).on('click', '#receiptBtn', function() {
            // Get the order ID from the data-order-id attribute
            const orderId = $(this).data('order-id');

            const orderInfo = getOrderData().gatherOrderInformation(orderId);
            
            displayOrderInformation(orderInfo);
        });

        // Display the order information in the modal
        function displayOrderInformation(orderInfo) {
            var currentDateElement = document.getElementById('currentDate');
            currentDateElement.textContent = orderInfo.order['date'];

            var orderInformationHtml = '<div class="asterisk-line"></div>';

            orderInfo.orderItems.forEach(function(orderItem) {
                item_price = parseFloat(orderItem.total_price);
                orderInformationHtml += `<p class="mb-0">${orderItem.quantity} x ${orderItem.product_name} (${orderItem.size}): $${item_price.toFixed(2)}</p>`;
            });

            orderInformationHtml += '<div class="asterisk-line"></div>';

            // Display other form data
            var total_price = parseFloat(orderInfo.order['total_price']);
            orderInformationHtml += `<p class="mb-0 mt-3">Total: $${total_price.toFixed(2)}</p>`;

            var payment_received = parseFloat(orderInfo.order['payment_received']);
            orderInformationHtml += `<p class="mb-0">Payment: $${payment_received.toFixed(2)}</p>`;

            var exact_change = parseFloat(orderInfo.order['exact_change']);
            orderInformationHtml += `<p class="mb-0">Change: $${exact_change.toFixed(2)}</p>`;
            orderInformationHtml += `<p>Payment Method: ${orderInfo.order['payment_method']}</p>`;

            orderInformationHtml += '<div class="asterisk-line"></div>';

            // Append to the modal body
            $('#order_information').html(orderInformationHtml);

            // Show the modal
            $('#receiptModal').modal('show');
        }

        // Print the modal body
        function printModalBody() {
            try {
                // Show the modal content
                const modalBody = document.getElementById('modalBodyContent');
                modalBody.style.display = 'block';

                // Print the modal content
                window.print();

            } catch (error) {
                alertify.set('notifier','position', 'top-right');
                alertify.error("Error during printModalBody: " + error);
            }
        }

        // Get the order data from PHP
        function getOrderData() {
            var orderResults = <?php echo json_encode($orderResults); ?>;
            var orderItems = <?php echo json_encode($orderItems); ?>;

            function gatherOrderInformation(orderId) {
                const selectedOrder = orderResults.find(order => order.order_id == orderId);
                const selectedOrderItems = orderItems.filter(orderItem => orderItem.order_id == orderId);

                return {
                    order: selectedOrder,
                    orderItems: selectedOrderItems
                };
            }

            return {
                gatherOrderInformation: gatherOrderInformation
            };
        }
    </script>
</body>
</html>
