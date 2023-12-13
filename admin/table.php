<?php
include "header.php";
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
?>

<!DOCTYPE html>
<html lang="en">

<body id="page-top">
    <div id="wrapper">
        <!-- Include menu_sidebar.php -->
        <?php include "menu_sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "menu_topbar.php"; ?>
                <div class="container mt-4">
                    <h2>Tambah Meja</h2>
                    <form method="post" action="process_table.php?action=add">
                        <div class="form-group">
                            <label for="table_number">Nomor Meja:</label>
                            <input type="text" class="form-control" id="table_number" name="table_number" required>
                        </div>
                        <div class="form-group">
                            <label for="table_type">Tipe Meja:</label>
                            <input type="text" class="form-control" id="table_type" name="table_type" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Meja</button>
                    </form>
                </div>
                <br>
                <div class="container mt-4">
                    <h2>Daftar Meja</h2>
                    <?php
                    $sql = "SELECT * FROM tables";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='table'>";
                        echo "<thead><tr><th>ID</th><th>Nomor Meja</th><th>Tipe Meja</th><th>Aksi</th></tr></thead><tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row['table_id'] . "</td><td>" . $row['table_number'] . "</td><td>" . $row['table_type'] . "</td>";
                            echo "<td><a href='edit_table.php?id=" . $row['table_id'] . "'>Edit</a> | 
                                  <a href='#' onclick='confirmDelete(" . $row['table_id'] . ")'>Hapus</a></td></tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "Tidak ada data meja.";
                    }
                    ?>
                </div>
            </div>
            <?php include "footer.php"; ?>
        </div>
    </div>

    <script>
        function confirmDelete(tableId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Meja ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'process_delete.php?id=' + tableId;
                }
            });
        }
    </script>
</body>

</html>
