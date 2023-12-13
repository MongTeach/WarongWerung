<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "koneksi.php";

     // Ambil data dari formulir reservasi
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $num_people = $_POST['num_people'];
    $selected_table_type = $_POST["meja"]; // This is the selected table type



    // Mencegah SQL injection
    $reservation_date = mysqli_real_escape_string($conn, $reservation_date);
    $reservation_time = mysqli_real_escape_string($conn, $reservation_time);
    $num_people = mysqli_real_escape_string($conn, $num_people);

    // Ambil informasi pengguna dari database
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username FROM users WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        // Handle ketika informasi pengguna tidak ditemukan
        $username = "Pengguna";
    }


    $insert_booking_query = "INSERT INTO booking (username, reservation_date, reservation_time, num_people, created_at, meja) 
                         VALUES ('$username', '$reservation_date', '$reservation_time', '$num_people', NOW(), '$selected_table_type')";


    if ($conn->query($insert_booking_query) === TRUE) {
        // Pemesanan berhasil
        header("Location: detail.php");
    } else {
        // Pemesanan gagal
        echo "Error: " . $insert_booking_query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
