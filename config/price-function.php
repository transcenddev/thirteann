<?php

// Code for price calculation in orders.php

require '../config/config.php';

// get prices
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['size']) && isset($_POST['product_name'])) {
    $selectedSize = $_POST['size'];
    $productName = $_POST['product_name'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0; // Ensure $quantity is numeric

    $stmt = $mysqli->prepare("SELECT DISTINCT price FROM product_table WHERE product_name = ? AND size = ?");
    $stmt->bind_param('ss', $productName, $selectedSize);
    $stmt->execute();
    $stmt->bind_result($price);

    while ($stmt->fetch()) {
        // Ensure $price is numeric
        $price = is_numeric($price) ? $price : 0;

        // Calculate the total price based on the quantity and unit price
        $totalPrice = $price * $quantity;

        // Format the total price as a decimal with .00
        $formattedTotalPrice = number_format($totalPrice, 2);

        echo $formattedTotalPrice; // Echo the formatted total price
    }

    $stmt->close();
} else {
    // Invalid request
    header('HTTP/1.1 400 Bad Request');
    exit();
}
?>
