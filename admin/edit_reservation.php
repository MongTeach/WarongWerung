<!-- edit_reservation.php -->
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


// Ambil informasi pengguna dari database
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
} else {
    // Handle when user information is not found
    $username = "Pengguna";
}

// Ambil ID reservasi dari parameter URL
$booking_id = $_GET['booking_id'];

// Query untuk mendapatkan data reservasi berdasarkan ID
$sql_select = "SELECT * FROM booking WHERE booking_id = $booking_id";
$result = $conn->query($sql_select);

// Periksa apakah reservasi ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $reservation_date = $row['reservation_date'];
    $reservation_time = $row['reservation_time'];
    $num_people = $row['num_people'];
    $status = $row['status'];
    $nomor_meja = $_POST['nomor_meja'] ?? '';
    $new_notes = $_POST['notes']  ?? '';
} else {
    // Handle jika reservasi tidak ditemukan
    echo "Reservation not found.";
    exit();
}

// Handle form submission for reservation update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $new_reservation_date = $_POST['new_reservation_date'];
    $new_reservation_time = $_POST['new_reservation_time'];
    $new_num_people = $_POST['new_num_people'];
    $new_status = $_POST['new_status'];
    $nomor_meja = $_POST['nomor_meja'];
    $new_notes = $_POST['notes'];

    // Validasi nomor meja
    $sql_check_table = "SELECT * FROM booking WHERE nomor_meja = '$nomor_meja' AND booking_id != $booking_id";
    $result_check_table = $conn->query($sql_check_table);

    if ($result_check_table->num_rows > 0) {
        // Nomor meja sudah digunakan dalam reservasi lain
        echo "<script>
                alert('Nomor meja sudah digunakan dalam reservasi lain. Pilih nomor meja lain.');
                window.location.href = 'edit_reservation.php?booking_id=$booking_id';
              </script>";
        exit();
    }

    // Update reservation in the database
    $sql_update = "UPDATE booking SET reservation_date = '$new_reservation_date', reservation_time = '$new_reservation_time', num_people = $new_num_people, status = '$new_status', nomor_meja = '$nomor_meja', notes = '$new_notes' WHERE booking_id = $booking_id";

    if ($conn->query($sql_update) === TRUE) {
        // Show SweetAlert success message
        echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <!-- Include SweetAlert CDN links here -->
                    <link rel='stylesheet' type='text/css' href='https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css'>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Reservation updated successfully!'
                        }).then(function() {
                            window.location.href = 'reservation_data.php';
                        });
                    </script>
                </body>
            </html>";
    } else {
        // Show SweetAlert error message
        echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <!-- Include SweetAlert CDN links here -->
                    <link rel='stylesheet' type='text/css' href='https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css'>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: 'Error: " . $sql_update . "<br>" . $conn->error . "'
                        });
                    </script>
                </body>
            </html>";
    }


}
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
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Reservation Data</h1>
                    </div>

                    <!-- Formulir penyuntingan -->
                    <div class="container">
                    <form method="post" action="edit_reservation.php?booking_id=<?php echo $booking_id; ?>">
                        <div class="form-group">
                            <label for="new_reservation_date">New Reservation Date:</label>
                            <input type="date" name="new_reservation_date" value="<?php echo $reservation_date; ?>" class="form-control" <?php echo ($_SESSION['role'] == 'pelayan') ? 'readonly' : ''; ?> required>
                        </div>

                        <div class="form-group">
                            <label for="new_reservation_time">New Reservation Time:</label>
                            <input type="time" name="new_reservation_time" value="<?php echo $reservation_time; ?>" class="form-control" <?php echo ($_SESSION['role'] == 'pelayan') ? 'readonly' : ''; ?> required>
                        </div>

                        <div class="form-group">
                            <label for="new_num_people">New Number of People:</label>
                            <input type="number" name="new_num_people" value="<?php echo $num_people; ?>" class="form-control" <?php echo ($_SESSION['role'] == 'pelayan') ? 'readonly' : ''; ?> required>
                        </div>

                        <label for="new_status">New Status:</label>
                        <select name="new_status" class="form-control">
                            <option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Confirmed" <?php echo ($status == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="complete" <?php echo ($status == 'complete') ? 'selected' : ''; ?>>Complete</option>
                        </select>

                        <!-- Formulir Pemilihan Nomor Meja -->
                        <div class="form-group">
                            <label for="nomor_meja">Nomor Table:</label>
                            <select class="form-control" id="nomor_meja" name="nomor_meja" required>
                                <?php
                                // Ambil data dari tabel tables
                                $sql = "SELECT DISTINCT table_number FROM tables";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['table_number'] . "'>" . $row['table_number'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada data meja.</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Akhir Formulir Pemilihan Meja -->

                        <div class="form-group">
                            <label for="notes">Notes:</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Enter notes here..."></textarea>
                        </div>

                        <br>
                        <br>
                        <button type="submit" name="submit" class="btn btn-primary">Update Reservation</button>
                    </form>

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
