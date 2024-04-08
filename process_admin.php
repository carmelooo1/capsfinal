<?php
include "conn.php";
session_start();

// Admin Login without Hashing
if (isset($_POST['log_email']) && isset($_POST['log_password'])) {
    $email = $_POST['log_email'];
    $password = $_POST['log_password'];

    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin['adminID'];
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_fname'] = $admin['fname']; 
        $_SESSION['admin_lname'] = $admin['lname']; 

        header("Location: /capstone/dashboard/dashboard_admin/index.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid email or password";
        header("Location: ui-admin.php");
        exit();
    }
} else {
    header("Location: ui-admin.php");
    exit();
}


if (isset($_POST['admin_register'])) {
    $adminID = $_POST['adminID'];
    $admin_fname = $_POST['admin_fname'];
    $admin_lname = $_POST['admin_lname'];
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    $insertQuery = "INSERT INTO `admin` (`adminID`, `fname`, `lname`, `email`, `password`) VALUES ('$adminID', '$admin_fname', '$admin_lname', '$admin_email', '$admin_password')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        echo "<script>alert('Registration successful. You can now login.');</script>";
        echo "<script>window.location.href = 'ui-admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('Registration failed. Please try again.');</script>";
        echo "<script>window.location.href = 'ui-admin-register.php';</script>";
        exit;
    }
}
