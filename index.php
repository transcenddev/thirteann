<?php

    // Code to check if a user is logged in if admin or staff then go to respective dashboard

    session_start();

    include 'config/config.php';

    // Check if the user is already logged in
    if (isset($_SESSION['user_id'])) {
        // Redirect based on the user's role
        $user_id = $_SESSION['user_id'];

        // Use prepared statement to prevent SQL injection
        $stmt = $mysqli->prepare("SELECT role FROM staff_table WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->bind_result($role);
            $stmt->fetch();
            $stmt->close();

            if ($role == 'Admin') {
                header("location: ./admin/dashboard.php");
                exit();
            } elseif ($role == 'Staff') {
                header("location: ./staff/dashboard.php");
                exit();
            }
        } else {
            // Handle database error
            die("Error in prepared statement: " . $mysqli->error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Discover a world of delightful flavors and seamless service with our innovative milk tea Point of Sale (POS) system. Simplify order management, optimize inventory, and elevate customer experiences. Explore the perfect blend of efficiency and technology for your milk tea shop.">
    <meta name="author" content="lokodata, transcenddev, j4zrel">
    <title>ThirTeaAnn's POS</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/index.css">

</head>
<body>
    <div class="container-fluid container">
        <h1>Login to your Account</h1>
        <p>Enter to continue and explore within your grasp</p>

        <form action="config/checklogin.php" method="POST" class="form">
            <label for="email" class="email">
                <img src="./assets/index_assets/user-vector.svg" alt="Email">
                <input id="email" type="text" name="email" placeholder="Enter email address" required /> 
            </label> 

            <label for="password" class="password">
                <img src="./assets/index_assets/lock-vector.svg" alt="Password">
                <input id="password" type="password" name="password" placeholder="Password" required /> 
            </label>

            <div class="remember_me">
                <input id="remember_me" type="checkbox" name="remember_me" /> 
                <label for="remember_me">Remember Me </label>
            </div>

            <input id="submit" class="submit" type="submit" value="Login to Continue" />
        </form>

        <!-- Error message -->
        <div id="error-message" class="alert alert-danger <?php echo isset($_GET['error']) ? '' : 'd-none'; ?>">
            <?php echo isset($_GET['error']) ? urldecode($_GET['error']) : ''; ?>
        </div>
    </div>
</body>
</html>
