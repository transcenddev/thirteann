<?php 

// Code for inventory add, edit, delete product

require '../config/config.php';

// Delete product
if(isset($_POST['delete_product']))
{
    $product_id = $mysqli->real_escape_string($_POST['product_id']);

    $query = "DELETE FROM product_table WHERE product_id = ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $product_id);
    
    if($stmt->execute())
    {
        $res = [
            'status' => 200,
            'message' => 'Product Deleted successfully'
        ];

        echo json_encode($res);
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Product Not Deleted'
        ];

        echo json_encode($res);
    }

    $stmt->close();
    return false;
}

// Save product
if (isset($_POST['save_product'])) {

    $product_name = $_POST['product_name'];
    $product_size = $_POST['product_size'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];

    if (isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0) {
        $product_image = file_get_contents($_FILES['product_image']['tmp_name']);
    } else {
        $response = array(
            'status' => 422,
            'message' => 'Product image is required.'
        );
        echo json_encode($response);
        exit;
    }

    if (empty($product_name) || empty($product_size) || empty($product_price) || empty($product_category)) {
        $response = array(
            'status' => 422,
            'message' => 'All fields are required.'
        );
    } else {

        // Insert product data into the database
        $stmt = $mysqli->prepare("INSERT INTO product_table (product_name, size, price, category, product_image) VALUES (?, ?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param('ssdss', $product_name, $product_size, $product_price, $product_category, $product_image);

        if ($stmt->execute()) {
            $response = array(
                'status' => 200,
                'message' => 'Product added successfully.'
            );
        } else {
            $response = array(
                'status' => 422,
                'message' => 'Error adding staff. Please try again.'
            );
        }

        $stmt->close();

        echo json_encode($response);
        exit;
    }
}

// Show data for edit
if(isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($mysqli, $_GET['product_id']);
    $query = "SELECT * FROM product_table WHERE product_id = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);

        // Encode the product_image to Base64
        $product['product_image'] = base64_encode($product['product_image']);

        $res = [
            'status' => 200,
            'message' => 'Product Fetch Successfully by Id',
            'data' => $product
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'message' => 'Product Id Not Found'
        ];
        echo json_encode($res);
    }

    mysqli_stmt_close($stmt);
    exit;
}

// Update product
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_size = $_POST['product_size'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];

    // Check if a new image file is uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0) {
        $product_image = file_get_contents($_FILES['product_image']['tmp_name']);
    } else {
        // No new image file uploaded, use the existing product_image value
        $result = mysqli_query($mysqli, "SELECT product_image FROM product_table WHERE product_id = $product_id");
        $row = mysqli_fetch_assoc($result);
        $product_image = $row['product_image'];
    }

    if (empty($product_name) || empty($product_size) || empty($product_price) || empty($product_category)) {
        $response = array(  
            'status' => 422,
            'message' => 'All fields are required.'
        );
    } else {
        // Assuming you have a prepared statement for insertion
        $stmt = $mysqli->prepare("UPDATE product_table SET product_name=?, product_image=?, size=?, price=?, category=? WHERE product_id = ?");
        
        $stmt->bind_param('sssdsi', $product_name, $product_image, $product_size, $product_price, $product_category, $product_id);

        if ($stmt->execute()) {
            $response = array(
                'status' => 200,
                'message' => 'Staff updated successfully.'
            );
        } else {
            $response = array(
                'status' => 422,
                'message' => 'Error updating staff. Please try again.'
            );
        }

        $stmt->close();
    }

    echo json_encode($response);
    exit;
}


?>