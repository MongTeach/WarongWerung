<!-- index.php -->

<?php
include "header.php";
include "koneksi.php";

// Cek apakah pengguna sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    // If not, redirect to the login page or take other actions as needed
    header("Location: login.php");
    exit();
}

// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];

// Dapatkan username pengguna saat ini
$sql_username = "SELECT username FROM users WHERE user_id = '$user_id'";
$result_username = $conn->query($sql_username);

if ($result_username->num_rows > 0) {
    $row_username = $result_username->fetch_assoc();
    $username = $row_username['username'];

    // READ - Display existing reservations for the logged-in user
    $sql_select = "SELECT * FROM booking WHERE username = '$username'";
    $result = $conn->query($sql_select);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here -->
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        #content-wrapper {
            flex: 1;
        }
    </style>
</head>
<body id="page-top">
    <?php include 'navbar.php'; ?>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Display existing reservations with Edit button -->
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Your Reservations</h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>username</th>
                                        <th>Reservation Date</th>
                                        <th>Reservation Time</th>
                                        <th>Number of People</th>
                                        <th>Table Type</th>
                                        <th>Status</th>
                                        <th>Table Number</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['booking_id']}</td>
                                                    <td>{$row['username']}</td>
                                                    <td>{$row['reservation_date']}</td>
                                                    <td>{$row['reservation_time']}</td>
                                                    <td>{$row['num_people']}</td>
                                                    <td>{$row['meja']}</td>
                                                    <td>{$row['status']}</td>
                                                    <td>{$row['nomor_meja']}</td>
                                                    <td>{$row['notes']}</td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No reservations found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

        <?php include "footer.php"; ?>
    </div>
    <!-- End of Page Wrapper -->
</body>
</html>
