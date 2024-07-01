<?php

// Code to check if user and password are correct and remember me function

// Function to generate a secure token for remember me
function generateToken() {
    // Generate a random string using random_bytes
    $randomBytes = random_bytes(32);

    // Convert the random bytes to a hexadecimal string
    $token = bin2hex($randomBytes);

    // Hash the token using password_hash
    $hashedToken = password_hash($token, PASSWORD_BCRYPT);

    return $hashedToken;
}

session_start();

include 'config.php';

// login fucntion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if "Remember Me" is checked
    $remember_me = isset($_POST['remember_me']);

    $stmt = $mysqli->prepare("SELECT email, password, user_id, role FROM staff_table WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($db_email, $db_password, $user_id, $role);
    $rs = $stmt->fetch();

    if ($rs) {

        if (password_verify($password, $db_password)) {
            // if successful
            $_SESSION['user_id'] = $user_id;

            if ($role == 'Admin') {
                header("location: /thirteaann-pos/admin/dashboard.php");
            } elseif ($role == 'Staff') {
                header("location: /thirteaann-pos/staff/dashboard.php");
            } else {
                $err = "Invalid user role.";
            }

            // Set a cookie if "Remember Me" is checked
            if ($remember_me) {
                $token = generateToken();
                setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
            }
        } else {
            $err = "Incorrect Password";
        }
    } else {
        // User not found in the database
        $err = "User not found.";
    }

    $stmt->close();

    // I need to make an error message appear on the login page
    if (isset($err)) {
        // Redirect back to index.php with an error message
        header("location: /thirteaann-pos/index.php?error=" . urlencode($err));
        exit();
    }
}
?>
