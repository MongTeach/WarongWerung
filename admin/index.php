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

function getTableCount($conn) {
    $sql = "SELECT COUNT(*) AS table_count FROM tables";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['table_count'];
}

function getAccountCount($conn, $role) {
    $sql = "SELECT COUNT(*) AS account_count FROM users WHERE role = '$role'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['account_count'];
}

function getReservationCount($conn) {
    $sql = "SELECT COUNT(*) AS reservation_count FROM booking";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['reservation_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "header.php"; ?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include "menu_sidebar.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include "menu_topbar.php"; ?>
                <br>
                <center><img src="img/unsrat2.png" alt="PLNlogo" width="150px"> </center>
                <br>
                <h2>
                    <center><b>SISTEM RESERVASI</b> </center>
                </h2>
                <h2>
                    <center><b>WarongWerung</b> </center>
                </h2>

                <!-- Add this section in the <div id="content"> ... </div> block -->

                <div class="container-fluid">

                    <!-- Cards for data summary -->
                    <div class="row">
                        <!-- Card for the number of tables -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-primary text-white shadow">
                                <div class="card-body">
                                    <div class="text-uppercase small">Jumlah Meja</div>
                                    <div class="h2 mb-0"><?php echo getTableCount($conn); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card for the number of customer accounts -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-success text-white shadow">
                                <div class="card-body">
                                    <div class="text-uppercase small">Akun Pelanggan</div>
                                    <div class="h2 mb-0"><?php echo getAccountCount($conn, 'pelanggan'); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card for the number of waiter accounts -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-warning text-white shadow">
                                <div class="card-body">
                                    <div class="text-uppercase small">Akun Pelayan</div>
                                    <div class="h2 mb-0"><?php echo getAccountCount($conn, 'pelayan'); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card for the number of reservations -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-danger text-white shadow">
                                <div class="card-body">
                                    <div class="text-uppercase small">Reservasi</div>
                                    <div class="h2 mb-0"><?php echo getReservationCount($conn); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <h2>

                    <br>
                    <center><a href="../index.php"><button class="btn btn-primary" type="button" href="../index.php">HOME</button></a></center>
                </h2>


            </div>
            <!-- End of Main Content -->
            <?php include "footer.php"; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>

</html>
