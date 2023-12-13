<?php
session_start();
include "../koneksi.php"; // Make sure the koneksi.php file is in the correct location

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // If not, redirect to the login page or take other actions as needed
    header("Location: ../login.php");
    exit();
}
// Additional check based on user role (assuming role values are 'pelanggan', 'manajer', 'pelayan')
$allowed_roles = ['manajer', 'pelayan'];

if (!in_array($_SESSION['role'], $allowed_roles)) {
    // Redirect to an error page or take other actions as needed
    echo "Peran pengguna tidak valid.";
    exit();
}
include "header.php";

// READ - Display existing reservations
$sql_select = "SELECT * FROM booking";
$result = $conn->query($sql_select);

?>

<!DOCTYPE html>
<html lang="en">
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include "menu_sidebar.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include "menu_topbar.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Display existing reservations with Edit button -->
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Existing Reservations</h3>
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
                                        <th>Nomor Meja</th>
                                        <th>Action</th>
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
                                                    <td>
                                                        <a href='edit_reservation.php?booking_id={$row['booking_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                    </td>
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
            <?php include "footer.php"; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>
</html>
