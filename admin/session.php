<?php
include "../koneksi.php"; // Make sure the koneksi.php file is in the correct location
// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    // If not, redirect to the login page or take other actions as needed
    header("Location: ../login.php");
    exit();
}

// Additional check based on user role (assuming role values are 'pelanggan', 'manajer', 'pelayan')
$allowed_roles = ['manajer', 'pelayan'];

if (!in_array($_SESSION['role'], $allowed_roles)) {
    // Redirect to an error page or take other actions as needed
    eader("Location: ../login.php");
    exit();
}
$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>