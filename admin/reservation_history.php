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
// READ - Display existing reservations with status 'Complete'
$sql_select = "SELECT * FROM booking WHERE status = 'Complete'";
$result = $conn->query($sql_select);

// Handle alert messages
$alert_type = '';
$alert_message = '';

// Check if alert parameters are set (from delete_reservation.php)
if (isset($_GET['alert_type']) && isset($_GET['alert_message'])) {
    $alert_type = $_GET['alert_type'];
    $alert_message = $_GET['alert_message'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- SweetAlert CDN CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

    <!-- SweetAlert CDN JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
</head>
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
                    <!-- Display existing reservations with Delete button -->
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Existing Reservations</h3>

                            <!-- Display Bootstrap modal for alert -->
                            <?php
                            if (!empty($alert_type) && !empty($alert_message)) {
                                echo "
                                    <div class='modal fade' id='alertModal' tabindex='-1' role='dialog' aria-labelledby='alertModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog' role='document'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='alertModalLabel'>Alert</h5>
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>
                                                <div class='modal-body'>
                                                    <div class='alert alert-$alert_type' role='alert'>$alert_message</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#alertModal').modal('show');
                                        });
                                    </script>
                                ";
                            }
                            ?>

                            <!-- Display alert before executing deletion -->
                            <div id="deleteAlert" class="alert alert-warning" role="alert" style="display: none;">
                                Are you sure you want to delete this reservation?
                                <button type="button" class="btn btn-danger btn-sm" id="confirmDelete">Yes, Delete</button>
                                <button type="button" class="btn btn-secondary btn-sm" id="cancelDelete">Cancel</button>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
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
                                                    <td>{$row['reservation_date']}</td>
                                                    <td>{$row['reservation_time']}</td>
                                                    <td>{$row['num_people']}</td>
                                                    <td>{$row['meja']}</td>
                                                    <td>{$row['status']}</td>
                                                    <td>{$row['nomor_meja']}</td>
                                                    <td>
                                                        <button class='btn btn-danger btn-sm' onclick=\"showDeleteAlert({$row['booking_id']})\">Delete</button>
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

    <script>
        function showDeleteAlert(bookingId) {
            // Display the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // If user confirms deletion
                if (result.isConfirmed) {
                    // Redirect to delete_reservation.php with booking_id parameter
                    window.location.href = 'delete_reservation.php?booking_id=' + bookingId;
                }
            });
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
