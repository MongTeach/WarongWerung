<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "koneksi.php";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Mencegah SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Cek apakah username sudah digunakan
    $check_username_query = "SELECT * FROM users WHERE username = '$username'";
    $check_username_result = $conn->query($check_username_query);

    if ($check_username_result->num_rows > 0) {
        // Username sudah digunakan
        echo "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Insert user baru ke database tanpa hashing
        $insert_user_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        
        if ($conn->query($insert_user_query) === TRUE) {
            // Registrasi berhasil
            header("Location: login.php");
        } else {
            // Registrasi gagal
            echo "Error: " . $insert_user_query . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
