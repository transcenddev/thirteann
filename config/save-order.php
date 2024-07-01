<?php

// Save all the data in order to database and return a form data for print 

require '../config/config.php';

// Create an associative array to hold the response data
$response = array();

// Check if the POST request contains the orderData parameter
if (isset($_POST['orderData'])) {
    $orderData = json_decode($_POST['orderData'], true);

    // Validate required fields
    if (empty($orderData['totalPrice']) || empty($orderData['paymentReceived']) || empty($orderData['exactChange']) || empty($orderData['paymentMethod']) || empty($orderData['products'])) {
        $response['error'] = 'One or more required fields are empty.';
    } else {
        // Set date to today's date
        $date = date("Y-m-d");

        // Fetch the current maximum receipt ID from the order_table
        $getMaxReceiptIdQuery = "SELECT MAX(CAST(SUBSTRING(receipt_id, 4) AS UNSIGNED)) AS max_receipt_number FROM order_table";
        $maxReceiptIdResult = $mysqli->query($getMaxReceiptIdQuery);

        if ($maxReceiptIdResult && $maxReceiptIdRow = $maxReceiptIdResult->fetch_assoc()) {
            $currentMaxReceiptNumber = $maxReceiptIdRow['max_receipt_number'];

            // Increment the receipt number
            $nextReceiptNumber = $currentMaxReceiptNumber + 1;

            // Generate a unique receipt ID with prefix "REC" and the incremented number
            $receiptId = 'REC' . $nextReceiptNumber;

            $totalPrice = $orderData['totalPrice'];
            $paymentReceived = $orderData['paymentReceived'];
            $exactChange = $orderData['exactChange'];
            $paymentMethod = $orderData['paymentMethod'];

            // Insert order data into the order_table
            $insertOrderQuery = "INSERT INTO order_table (date, receipt_id, total_price, payment_received, exact_change, payment_method) 
                                VALUES ('$date', '$receiptId', $totalPrice, $paymentReceived, $exactChange, '$paymentMethod')";

            if ($mysqli->query($insertOrderQuery) === TRUE) {
                // Get the order ID of the inserted record
                $orderId = $mysqli->insert_id;

                // Insert order items into the order_items table
                foreach ($orderData['products'] as $product) {
                    // Validate required fields for each product
                    if (empty($product['productName']) || empty($product['size']) || empty($product['price']) || empty($product['quantity']) || empty($product['total'])) {
                        $response['error'] = 'One or more required fields for a product are empty.';
                    } else {
                        $productName = $mysqli->real_escape_string($product['productName']);
                        $size = $mysqli->real_escape_string($product['size']);
                        $price = $product['price'];
                        $quantity = $product['quantity'];
                        $total = $product['total'];

                        // Query the product_table to get the product_id
                        $getProductIdQuery = "SELECT product_id FROM product_table WHERE product_name = '$productName' AND size = '$size'";
                        $productIdResult = $mysqli->query($getProductIdQuery);

                        if ($productIdResult && $productIdRow = $productIdResult->fetch_assoc()) {
                            $productId = $productIdRow['product_id'];

                            // Insert order item into the order_items table
                            $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, product_name, size, price, quantity, total_price) 
                                                VALUES ($orderId, $productId, '$productName', '$size', $price, $quantity, $total)";

                            $mysqli->query($insertOrderItemQuery);
                        } else {
                            $response['error'] = 'Error getting product ID: ' . $mysqli->error;
                            break;
                        }
                    }
                }

                if (!isset($response['error'])) {
                    $response['success'] = 'Order saved successfully';
                }
            } else {
                $response['error'] = 'Error saving order: ' . $mysqli->error;
            }
        } else {
            $response['error'] = 'Error getting max receipt number: ' . $mysqli->error;
        }
    }
} else {
    // If the orderData parameter is not present
    $response['error'] = 'Invalid request';
}

// Convert the response array to JSON and echo it
echo json_encode($response);
?>
