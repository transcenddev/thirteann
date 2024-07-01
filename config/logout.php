<?php

    // Code to logout the user and destroy the session

    session_start();

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Delete the "Remember Me" cookie if it exists
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, '/');
    }

    // Redirect to the login page
    header("location: ../index.php");
    exit();
?>