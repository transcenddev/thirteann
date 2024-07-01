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
</head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>


    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/orders.css">
    <link rel="stylesheet" href="../styles/admin-sidebar.css">
    <script defer src="../assets/js/table.js"></script>
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
                    <button type="button" class="btn btn-primary" onclick="printModalBody()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigator -->
    <?php require "../config/admin-sidebar.php"; ?>
    
    <div class="main-content">
        <div class="inventory">
            <div class="categories">

                <!-- Get All Category and Populate as buttons for Filter -->
                <?php
                    require '../config/config.php';
                    
                    // Fetch distinct categories from the database
                    $categoryStmt = $mysqli->prepare("SELECT DISTINCT category FROM product_table");
                    $categoryStmt->execute();
                    $categoryStmt->bind_result($distinctCategory);

                    // Generate a button for 'All' category
                    echo "<button class='btn mx-2 my-2 category-btn' onclick='filterByCategory(\"All\")'>All</button>";

                    // Generate a button for each distinct category
                    while ($categoryStmt->fetch()) {
                        echo "<button class='btn mx-2 my-2 category-btn' onclick='filterByCategory(\"$distinctCategory\")'>$distinctCategory</button>";
                    }

                    // Close the statement
                    $categoryStmt->close();
                ?>
            </div>

            <table class="table" id="product_table">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Query All Products and Populate to Table-->
                    <?php
                        require '../config/config.php';

                        // Fetch products with the initial condition (e.g., size)
                        $stmt = $mysqli->prepare("SELECT * FROM product_table ORDER by product_name ASC");
                        $stmt->execute();
                        $stmt->bind_result($product_id, $product_image, $product_name, $size, $unit_price, $category);

                        while ($stmt->fetch()) {
                            echo "<tr data-product-id='$product_id' data-category='$category'>";
                                echo "<td data-cell=''><img class='product_image' src='data:image/png;base64, " . base64_encode($product_image) . "' alt='Product Image'></td>";
                                echo "<td>$product_name</td>";
                                echo "<td>$size</td>";
                                echo "<td>$unit_price</td>";
                            echo "</tr>";
                        }

                        $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="order" id="order_details">
            <div id="errorMessageSave" class="alert alert-warning d-none"></div>

            <form id="order_form">
                <table class="table" id="order_table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 
                            When any of the row is clicked it will show up to the Order
                        -->
                    </tbody>

                    <tfoot>
                        <tr>
                            <td>Total:</td>
                            <td data-cell='Total Price' id="total_price">0.00</td>
                        </tr>

                        <tr>
                            <td>Payment Received:</td>
                            <td data-cell='Amount' id="payment_received">
                                <input type='tel' pattern='[0-9]*' inputmode='numeric' placeholder="123" oninput="updateExactChange()">
                            </td>
                        </tr>


                        <tr>
                            <td>Exact Change:</td>
                            <td data-cell='Change' id="change">0.00</td>
                        </tr>

                        <tr>
                            <td>Payment Method:</td>
                            <td data-cell='Payment' id="payment_method" class="payment_method">
                                <label>
                                    <input type="radio" name="payment_method" value="Cash"> Cash
                                </label>
                                <label>
                                    <input type="radio" name="payment_method" value="Gcash"> GCash
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <td class="action" data-cell='Amount'>
                                <button type="button" class="btn" id='saveOrderBtn'>
                                    Save Order
                                </button>
                                <button type="button" class="btn" id='clearOrderBtn'>
                                    Clear
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        // Change table to DataTable of jQuery
        function initializeDataTable() {
            $('#product_table').DataTable({
                paging: true,
                pageLength: 15,
                lengthChange: false,
            });
        }

        $(document).ready(function () {
            initializeDataTable();
        });

        // Function to filter the products by category
        function filterByCategory(selectedCategory) {
            var table = $('#product_table').DataTable();

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var rowCategory = $(table.row(dataIndex).node()).data('category');
                return (selectedCategory === 'All' || rowCategory === selectedCategory);
            });

            table.draw();

            // Remove the filter immediately after drawing the table
            $.fn.dataTable.ext.search.pop();
        }

        // Function to clear the order and reset form values
        function clearOrder() {
            // Remove all rows from the order table
            $('#order_table tbody tr').remove();

            // Reset total price, payment received, and exact change
            $('#total_price').text('0.00');
            $('#payment_received input').val('');
            $('#change').text('0.00');

            // Uncheck payment method radio buttons
            $('input[name="payment_method"]').prop('checked', false);

            // Update the display
            updateExactChange();
        }

        // Attach the clearOrder function to the click event of the clear order button
        $('#clearOrderBtn').click(function() {
            clearOrder();
        });

        var selectedProducts = [];

        // Handle click event on the product table to order table
        $(document).on('click', '#product_table tbody tr', function() {
            var productId = $(this).data('product-id');

            // Check if the product is already in the order table
            var existingRow = $('#order_table tbody tr[data-product-id="' + productId + '"]');
            if (existingRow.length > 0) {
                // If the product already exists, trigger incrementQuantity
                incrementQuantity(existingRow.find('.increment-btn'));
            } else {
                // If the product is not in the table yet, use AJAX to fetch product details
                $.ajax({
                    url: '../config/orders-function.php',
                    method: 'POST',
                    data: { productId: productId },
                    success: function(response) {
                        // Append the new row for the selected product
                        $('#order_table tbody').append(response);
                        
                        updateTotalPrice(); // Trigger updateTotalPrice after appending the row
                        updateExactChange();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });

        // Handle change event that affect quantity increase
        window.incrementQuantity = function(button) {
            var inputElement = $(button).parent().prev().find('input[name="quantity"]');
            var currentQuantity = parseInt(inputElement.val(), 10);
            inputElement.val(currentQuantity + 1);

            // Trigger the updatePrices function after incrementing the quantity
            updatePrices(inputElement.closest('tr').find('select[name="size"]')[0]);
            updateTotalPrice();
            updateExactChange();
        }   

        // Handle change event that affect quantity decrease
        window.decrementQuantity = function(button) {
            var inputElement = $(button).parent().prev().find('input[name="quantity"]');
            var currentQuantity = parseInt(inputElement.val(), 10);
            
            if (currentQuantity > 1) {
                inputElement.val(currentQuantity - 1);

                // Trigger the updatePrices function after decrementing the quantity
                updatePrices(inputElement.closest('tr').find('select[name="size"]')[0]);
                updateTotalPrice();
                updateExactChange();
            }
        }

        // Handle change event on the size dropdown
        window.removeItem = function(button) {
            $(button).closest('tr').remove();
            updateTotalPrice();
            updateExactChange();
        }

        // Handle save order button click using event delegation
        $(document).on('click', '#saveOrderBtn', function() {
            updateTotalPrice();
            updateExactChange();
            var formData = gatherFormData(); 
            saveOrder(formData);
        });

        // Function to save the order to the database
        function saveOrder(formData) {
            // Make an AJAX request to save-order.php
            $.ajax({
                type: 'POST',
                url: '../config/save-order.php',
                data: { orderData: JSON.stringify(formData) }, // Sending the order data as JSON string
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    // Check the response from the server to determine success or error
                    alertify.set('notifier','position', 'top-right');

                    if (response.success) {
                        alertify.success(response.success);
                        $('#saveOrderBtn').attr('data-bs-target', '#receiptModal');
                        displayOrderInformation(formData);
                        clearOrder();
                    } else {
                        alertify.error('Error saving order: ' + response.error);
                    }
                }
            });
        }

        // Function to gather form data
        function gatherFormData() {
            var formData = {
                products: []
            };

            // Iterate through each row in the table body
            $('#order_table tbody tr').each(function () {
                var productName = $(this).find('td:nth-child(1)').text().trim();
                
                // Assuming the size is selected through a dropdown (select) element
                var size = $(this).find('select[name="size"]').val().trim();

                var price = parseFloat($(this).find('td:nth-child(3)').text().trim());
                var quantity = parseInt($(this).find('input[name="quantity"]').val());
                var total = price;

                formData.products.push({
                    productName: productName,
                    size: size,
                    price: price,
                    quantity: quantity,
                    total: total
                });
            });

            // Get other form data
            formData.totalPrice = parseFloat($('#total_price').text().trim());
            formData.paymentReceived = parseFloat($('#payment_received input').val());
            formData.exactChange = parseFloat($('#change').text().trim());
            formData.paymentMethod = $('input[name="payment_method"]:checked').val();

            return formData;
        }

        // Function to print the form data to modal body print
        function displayOrderInformation(formData) {
            var orderInformationHtml = '<div class="asterisk-line"></div>';
            formData.products.forEach(function(product) {
                orderInformationHtml += `<p class="mb-0">${product.quantity} x ${product.productName} (${product.size}): $${product.total.toFixed(2)}</p>`;
            });

            orderInformationHtml += '<div class="asterisk-line"></div>';

            // Display other form data
            orderInformationHtml += `<p class="mb-0 mt-3">Total: $${formData.totalPrice.toFixed(2)}</p>`;
            orderInformationHtml += `<p class="mb-0">Payment: $${formData.paymentReceived.toFixed(2)}</p>`;
            orderInformationHtml += `<p class="mb-0">Change: $${formData.exactChange.toFixed(2)}</p>`;
            orderInformationHtml += `<p>Payment Method: ${formData.paymentMethod}</p>`;

            orderInformationHtml += '<div class="asterisk-line"></div>';

            // Dynamically set the current date and time
            var currentDateElement = document.getElementById('currentDate');
            var currentDate = new Date();
            var options = { year: 'numeric', month: 'numeric', day: 'numeric'};
            currentDateElement.textContent = currentDate.toLocaleString('en-US', options);

            // Append to the modal body
            $('#order_information').html(orderInformationHtml);

            // Show the modal
            $('#receiptModal').modal('show');
        }

        // Function to update the exact change based on payment received and total price
        function updateExactChange() {
            var paymentReceivedInput = $('#payment_received input');

            // Ensure that the input element is found before attempting to read its value
            if (paymentReceivedInput.length > 0) {
                var paymentReceivedValue = paymentReceivedInput.val().trim();
                var paymentReceived = parseFloat(paymentReceivedValue) || 0;
                var totalPrice = parseFloat($('#total_price').text()) || 0;

                var exactChange = Math.max(0, paymentReceived - totalPrice);

                // Update the exact change in the DOM
                $('#change').text(exactChange.toFixed(2));
            } else {
                console.error('Payment received input not found.');
            }
        }

        // Function to update the total price based on selected products
        function updateTotalPrice() {
            var total = 0;

            // Iterate over each selected product row
            $('#order_table tbody tr').each(function() {
                var priceText = $(this).find('#priceText').text();
                var price = parseFloat(priceText.replace(',', '')); // Remove comma and convert to float
                var quantity = parseInt($(this).find('input[name="quantity"]').val(), 10);

                total += price;
            });

            // Update the total price in the total row
            $('#total_price').text(total.toFixed(2));
        }

        // Modify the updatePrices function to handle price ranges
        function updatePrices(element) {
            var row = $(element).closest('tr');
            var selectedSize = row.find('select[name="size"]').val();
            var quantity = row.find('input[name="quantity"]').val();

            $.ajax({
                url: '../config/price-function.php',
                method: 'POST',
                data: { size: selectedSize, product_name: row.find('td:first').text(), quantity: quantity },
                success: function(response) {
                    var priceText = parsePriceRange(response); // Parse the price range
                    row.find('#priceText').text(priceText);

                    // Trigger the update of total price after updating individual product price
                    updateTotalPrice();
                    updateExactChange();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Function to parse price range and return the average price
        function parsePriceRange(priceRange) {
            var prices = priceRange.split('-');
            var averagePrice = prices.reduce(function (sum, price) {
                return sum + parseFloat(price.trim());
            }, 0) / prices.length;

            return averagePrice.toFixed(2);
        }

    </script>

</body>
</html>