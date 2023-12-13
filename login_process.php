<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "koneksi.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencegah SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Mengecek informasi login
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Login berhasil
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect sesuai dengan peran pengguna
        switch ($_SESSION['role']) {
            case 'pelanggan':
                header("Location: index.php");
                break;
            case 'manajer':
                header("Location: admin/index.php");
                break;
            case 'pelayan':
                header("Location: admin/index.php");
                break;
            default:
                echo "Peran pengguna tidak valid.";
        }
    } else {
        // Informasi login salah
        echo "Username atau password salah.";
    }

    $conn->close();
}
?>
