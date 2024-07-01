<?php 

// Code for HRM add, edit, delete staff

require '../config/config.php';

// Delete staff
if(isset($_POST['delete_staff']))
{
    $user_id = $mysqli->real_escape_string($_POST['user_id']);

    $query = "DELETE FROM staff_table WHERE user_id = ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    
    if($stmt->execute())
    {
        $res = [
            'status' => 200,
            'message' => 'Staff Deleted successfully'
        ];

        echo json_encode($res);
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Staff Not Deleted'
        ];

        echo json_encode($res);
    }

    $stmt->close();
    return false;
}

// Save staff
if (isset($_POST['save_staff'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact_number = $_POST['contact_number'];
    $role = $_POST['role'];

    // Validate data if needed (you can use a more robust validation approach)
    if (empty($name) || empty($email) || empty($password) || empty($contact_number) || empty($role)) {
        $response = array(
            'status' => 422,
            'message' => 'All fields are required.'
        );
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Assuming you have a prepared statement for insertion
        $stmt = $mysqli->prepare("INSERT INTO staff_table (name, email, contact_number, role, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $contact_number, $role, $hashed_password);

        if ($stmt->execute()) {
            $response = array(
                'status' => 200,
                'message' => 'Staff added successfully.'
            );
        } else {
            $response = array(
                'status' => 422,
                'message' => 'Error adding staff. Please try again.'
            );
        }

        $stmt->close();
    }

    echo json_encode($response);
    exit;
}

// Show data for edit
if(isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($mysqli, $_GET['user_id']);
    $query = "SELECT * FROM staff_table WHERE user_id = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $staff = mysqli_fetch_assoc($result);
        $res = [
            'status' => 200,
            'message' => 'Staff Fetch Successfully by Id',
            'data' => $staff
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 404,
            'message' => 'Staff Id Not Found'
        ];
        echo json_encode($res);
    }

    mysqli_stmt_close($stmt);
    exit;
}

// Update staff
if (isset($_POST['update_staff'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact_number = $_POST['contact_number'];
    $role = $_POST['role'];

    // Validate data if needed (you can use a more robust validation approach)
    if (empty($name) || empty($email) || empty($password) || empty($contact_number) || empty($role)) {
        $response = array(
            'status' => 422,
            'message' => 'All fields are required.'
        );
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Assuming you have a prepared statement for insertion
        $stmt = $mysqli->prepare("UPDATE staff_table SET name=?, email=?, password=?, contact_number=?, role=? WHERE user_id = ?");
        $stmt->bind_param("sssssi", $name, $email, $hashed_password, $contact_number, $role, $user_id);

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