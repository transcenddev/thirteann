<?php

// Get the product from the product table to order table and display it in the order table

require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    $stmt = $mysqli->prepare("SELECT product_name, size, price FROM product_table WHERE product_id = ?");
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $stmt->bind_result($productName, $size, $price);
    $stmt->fetch();
    $stmt->close();

    // Fetch all available sizes for the product
    $sizeStmt = $mysqli->prepare("SELECT DISTINCT size FROM product_table WHERE product_name = ?");
    $sizeStmt->bind_param('s', $productName);
    $sizeStmt->execute();
    $sizeStmt->bind_result($availableSize);

    echo "<tr data-product-id='$productId'>";
    echo "<td>$productName</td>";
    echo "<td>";
    echo "<select name='size' onchange='updatePrices(this)'>";
    
    // Populate size dropdown
    while ($sizeStmt->fetch()) {
        echo "<option value='$availableSize'>$availableSize</option>";
    }

    echo "</select>";
    echo "</td>";

    // Close the result set for sizes
    $sizeStmt->close();

    echo "<td id='priceText'>$price</td>"; // Use a td with an id to display the price

    echo "<td id='quantity'>";
    echo "<input type='tel' pattern='[0-9]*' inputmode='numeric' name='quantity' value='1' min='1' onchange='updatePrices(this)'>";
    echo "</td>";

    echo "<td class='order_action'>";
    echo "<button type='button' class='btn btn-sm increment-btn' onclick='incrementQuantity(this)'>+</button>";
    echo "<button type='button' class='btn btn-sm' onclick='decrementQuantity(this)'>-</button>";
    echo "<button type='button' class='btn btn-sm' onclick='removeItem(this)'>Remove</button>";
    echo "</td>";
    echo "</tr>";
} else {
    // Invalid request
    header('HTTP/1.1 400 Bad Request');
    exit();
}


?>
