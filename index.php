<?php
session_start();
include "koneksi.php"; // Make sure the koneksi.php file is in the correct location

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // If not, redirect to the login page or take other actions as needed
    header("Location: login.php");
    exit();
}

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
?>

<!-- header.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <!-- Add a carousel for showcasing restaurant images -->
    <div id="restaurantCarousel" class="carousel slide" data-ride="carousel">
    <!-- Add ORDER RESERVATION text in the center at the top -->
    <div class="carousel-caption d-md-block text-center" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
        <a href="#form" class="btn btn-warning" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">ORDER RESERVATION</a>
    </div>


        <div class="carousel-inner" style="height: 550px;"> <!-- Adjust the height as needed -->
            <!-- Add carousel items with restaurant images -->
            <div class="carousel-item active">
                <img src="https://restorangaruda.com/imagesfile/banner_restoran-garuda-nikmatnya-santapan-sejuta-kesan.jpeg" class="d-block w-100" alt="Restaurant Image 1" style="object-fit: cover; height: 100%;">
            </div>
            <div class="carousel-item">
                <img src="https://kayumanisresto.com/wp-content/uploads/2022/10/gallery-venue-1.jpg" class="d-block w-100" alt="Restaurant Image 2" style="object-fit: cover; height: 100%;">
            </div>
            <!-- Add more carousel items as needed -->
        </div>
        
        <!-- Add carousel controls if desired -->
        <a class="carousel-control-prev" href="#restaurantCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#restaurantCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

        <!-- Section: Deskripsi WarungWerung -->
    <div class="row mb-4 mt-5">
        <div class="col-md-6">
            <img src="https://kayumanisresto.com/wp-content/uploads/2022/10/header-menu-set-menu.jpg" style="height: 400px;" class="img-fluid" alt="WarungWerung Image">
        </div>
        <div class="col-md-6">
            <h2>WarungWerung</h2>
            <p>
                WarungWerung, a culinary haven in the heart of Manado, captivates diners with a delightful blend of traditional charm and contemporary flair. Specializing in [cuisine type], this inviting eatery curates an impressive menu that showcases a fusion of local and global flavors. With a commitment to using fresh, locally sourced ingredients, WarungWerung promises a memorable dining experience, where every dish tells a story of culinary expertise and passion.
            </p>
            <!-- Add more description as needed -->
        </div>
    </div>
    <!-- End Section: Deskripsi WarungWerung -->

    <h2 class="mt-5">Food Menu</h2>
    <!-- Add a section for displaying menu items -->
    <div class="row mt-5">
        <!-- Add menu items with images and descriptions -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://kayumanisresto.com/wp-content/uploads/2022/11/signature-ikan-bakar-paket.jpg" class="card-img-top" alt="Food Item 1">
                <div class="card-body">
                    <h5 class="card-title">Paket Bakar Jimbaran</h5>
                    <p class="card-text">grilled marinated snapper served with clam, water spinach, sambal and rice</p>
                </div>
            </div>
        </div>
        <!-- Add more menu items as needed -->
                <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://kayumanisresto.com/wp-content/uploads/2022/10/signature-cendol.jpg" class="card-img-top" alt="Food Item 1">
                <div class="card-body">
                    <h5 class="card-title">Cendol Ngangenin</h5>
                    <p class="card-text">cendol, kue lumpur, kolak pisang served with coconut ice cream</p>
                </div>
            </div>
        </div>
                <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://kayumanisresto.com/wp-content/uploads/2022/10/signature-bebek.jpg" class="card-img-top" alt="Food Item 1">
                <div class="card-body">
                    <h5 class="card-title">Bebek Panggang Mekudus</h5>
                    <p class="card-text">traditional grill smoky duck serves with minced chicken skewer,  clear chicken soup</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Formulir Reservasi -->
    <h2 class="mt-5">Reservation</h2>
    <form class="mt-3" id="form" method="post" action="process_booking.php" style="padding: 20px; border-radius: 10px;">
        <div class="form-group">
            <label for="reservation_date">Tanggal Reservasi:</label>
            <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
        </div>

        <div class="form-group">
            <label for="reservation_time">Waktu Reservasi:</label>
            <input type="time" class="form-control" id="reservation_time" name="reservation_time" required>
        </div>

        <div class="form-group">
            <label for="num_people">Jumlah Orang:</label>
            <input type="number" class="form-control" id="num_people" name="num_people" required>
        </div>

        <!-- Formulir Pemilihan Meja -->
        <div class="form-group">
            <label for="meja">Pilih Tipe Meja:</label>
            <select class="form-control" id="meja" name="meja" required>
                <?php
                // Ambil data dari tabel tables
                $sql = "SELECT DISTINCT table_type FROM tables";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['table_type'] . "'>" . $row['table_type'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada data meja.</option>";
                }
                ?>
            </select>
        </div>
        <!-- Akhir Formulir Pemilihan Meja -->

        <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
    <!-- Akhir Formulir Reservasi -->

</div>

<?php include 'footer.php'; ?>
</body>
</html>
