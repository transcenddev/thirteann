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
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" href="../styles/inventory.css">
</head>
<body>
    <!-- Add Product Modal -->
    <div class="modal fade" id="productAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="saveProduct" action="">
                    <div class="modal-body">

                        <div id="errorMessageSave" class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="product_image">Image</label>
                            <input type="file" name="product_image" accept="image/*" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="product_size">Size</label>
                            <select name="product_size" class="form-control">
                                <option value="500 ml">500 ml</option>
                                <option value="700 ml">700 ml</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="product_price">Unit Price</label>
                            <input type="number" name="product_price" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="product_category">Category</label>
                            <select name="product_category" class="form-control">
                                <option value="Traditional Flavors">Traditional Flavors</option>
                                <option value="Premium Flavors">Premium Flavors</option>
                                <option value="Surprise Blends Flavors">Surprise Blends Flavors</option>
                                <option value="Cheesecake & Cloud Series">Cheesecake & Cloud Series</option>
                                <option value="Fruit Teas">Fruit Teas</option>
                                <option value="Yogurt Series">Yogurt Series</option>
                                <option value="Coffee Series">Coffee Series</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="productEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="updateProduct" action="">
                    <div class="modal-body">

                        <div id="errorMessageSave" class="alert alert-warning d-none"></div>

                        <input type="hidden" name="product_id" id="product_id">

                        <div class="mb-3">
                            <label for="product_image">Image</label>
                            <img src="" id="product_image" class="product_image" alt="Product Image">
                            <input type="file" name="product_image" accept="image/*" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" id="product_name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="product_size">Size</label>
                            <select name="product_size" id="product_size" class="form-control">
                                <option value="500 ml">500 ml</option>
                                <option value="700 ml">700 ml</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="product_price">Unit Price</label>
                            <input type="number" name="product_price" id="product_price" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="product_category">Category</label>
                            <select name="product_category" id="product_category" class="form-control">
                                <option value="Traditional Flavors">Traditional Flavors</option>
                                <option value="Premium Flavors">Premium Flavors</option>
                                <option value="Surprise Blends Flavors">Surprise Blends Flavors</option>
                                <option value="Cheesecake & Cloud Series">Cheesecake & Cloud Series</option>
                                <option value="Fruit Teas">Fruit Teas</option>
                                <option value="Yogurt Series">Yogurt Series</option>
                                <option value="Coffee Series">Coffee Series</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigator -->
    <?php require "../config/staff-sidebar.php"; ?>
    
    <div class="main-content">
        <div class="header-inventory">
            <h1>Inventory Management</h1>

            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#productAddModal">Add New Product</button>
        </div>

        <div class="table-section">
            <table class="table" id="product_table">
                <h1></h1>
                <thead>
                    <tr>
                        <th></th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Unit Price</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Query All Products and Populate to Table-->
                    <?php
                        require '../config/config.php';

                        $stmt = $mysqli->prepare("SELECT * FROM product_table");
                        $stmt->execute();
                        $stmt->bind_result($product_id, $product_image, $product_name, $size, $price, $category);

                        while ($stmt->fetch()) {
                            echo "<tr>";    
                            echo "<td><img class='product_image' src='data:image/png;base64, " . base64_encode($product_image) . "' alt='Product Image'></td>";

                            echo "<td>$product_name</td>";
                            echo "<td>$size</td>";
                            echo "<td>$price</td>";
                            echo "<td>$category</td>";
                            echo "<td>
                                    <button class='btn edit-btn' data-bs-toggle='modal' data-bs-target='#productEditModal' data-product-id='$product_id'> Edit </button>

                                    <button class='btn delete-btn' data-product-id='$product_id'> Delete </button>
                                </td>";
                            echo "</tr>";
                        }

                        $stmt->close();
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
            $('#product_table').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
            });
        }

        $(document).ready(function () {
            initializeDataTable();
        });
        
        // add Product
        $(document).on('submit', '#saveProduct', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_product", true);
            
            $.ajax({
                type: "POST",
                url: "../config/inventory-function.php",
                data: formData,        
                processData: false,
                contentType: false,
                success: function (response) {

                    var res = JSON.parse(response);

                    if (res.status == 422) {
                        $("#errorMessageSave").removeClass('d-none');
                        $("#errorMessageSave").text(res.message);
                    } else if (res.status == 200) {
                        $("#errorMessageSave").addClass('d-none');
                        $('#productAddModal').modal('hide');
                        $('#saveProduct')[0].reset();

                        alertify.set('notifier','position', 'bottom-right');
                        alertify.success(res.message);

                        // Destroy the DataTable instance
                        $('#staff_table').DataTable().destroy();

                        // Reload the page
                        location.reload(true);
                    }
                }
            });
        });

        // fetch data for editing
        $(document).on('click', '.edit-btn', function () {
            var productId = $(this).data('product-id');

            $.ajax({
                type: "GET",
                url: "../config/inventory-function.php",
                data: { product_id: productId },
                success: function (response) {
                    
                    var res = JSON.parse(response);
                    
                    if (res.status == 422) {
                        alert(res.message);
                    } else if (res.status == 200) {
                        // Populate the form fields in the Edit Product modal
                        $('#product_id').val(res.data.product_id);
                        $('#product_name').val(res.data.product_name);
                        $('#product_price').val(res.data.price);

                        var sizeValue = res.data.size;
                        $('#product_size').val(sizeValue);

                        var categoryValue = res.data.category;
                        $('#product_category').val(categoryValue);

                        // Set the image source with the encoded image data
                        $('#product_image').attr('src', 'data:image/jpeg;base64,' + res.data.product_image);

                        // Show the Edit Product modal
                        $('#productEditModal').modal('show');
                    } else {
                        alertify.error(res.message);
                    }
                }
            });
        });

        // update product
        $(document).on('submit', '#updateProduct', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_product", true);

            $.ajax({
                type: "POST",
                url: "../config/inventory-function.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {

                    console.log(response);
                 
                    var res = JSON.parse(response);

                    if (res.status == 422) {
                        $("#errorMessageUpdate").removeClass('d-none');
                        $("#errorMessageUpdate").text(res.message);
                    } else if (res.status == 200) {
                        $("#errorMessageUpdate").addClass('d-none');
                        $('#productEditModal').modal('hide');
                        $('#updateProduct')[0].reset();

                        alertify.set('notifier','position', 'bottom-right');
                        alertify.success(res.message);

                        // Destroy the DataTable instance
                        $('#staff_table').DataTable().destroy();

                        // Reload the page
                        location.reload(true);
                    }
                }
            });
        });

        // delete product
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var productId = $(this).data('product-id');

                $.ajax({
                    type: "POST",
                    url: "../config/inventory-function.php",
                    data: {
                        'delete_product': true,
                        'product_id': productId,
                    },
                    success: function (response) {

                        var res = JSON.parse(response);

                        if (res.status == 500) {
                            alert(res.message);
                        } else {
                            alertify.set('notifier','position', 'bottom-right');
                            alertify.success(res.message);

                            // Destroy the DataTable instance
                            $('#staff_table').DataTable().destroy();

                            // Reload the page
                            location.reload(true);
                        }
                    }
                });
            }
        });

    </script>

</body>
</html>