<?php
session_start();
include "../koneksi.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "header.php";

// Ambil ID meja dari parameter URL
$table_id = $_GET['id'];

// Ambil data meja dari tabel
$sql = "SELECT * FROM tables WHERE table_id = '$table_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
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
                <div class="container mt-4">
                    <h2>Edit Meja</h2>

                    <form method="post" action="process_table.php?action=edit">
                        <input type="hidden" name="table_id" value="<?php echo $row['table_id']; ?>">
                        
                        <div class="form-group">
                            <label for="table_number">Nomor Meja:</label>
                            <input type="text" class="form-control" id="table_number" name="table_number" value="<?php echo $row['table_number']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="table_type">Tipe Meja:</label>
                            <input type="text" class="form-control" id="table_type" name="table_type" value="<?php echo $row['table_type']; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>

                <br>
                   
                </h2>
            </div>
            <?php
            } else {
                echo "Meja tidak ditemukan.";
            }
            include 'footer.php';
            ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>
</html>
<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Include Chart.js library and datalabels plugin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
