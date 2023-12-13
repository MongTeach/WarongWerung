<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">WarongWarem</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="detail.php">Detail Reservation</a>
            </li>
        </ul>
        <span class="navbar-text">
            <?php
            // Cek apakah pengguna sudah login
            if (isset($_SESSION['user_id'])) {
                echo "Selamat Datang, " . $username . "!";
                // Add a random photo (placeholder image)
                $randomPhoto = "https://placekitten.com/30/30"; // Placeholder image URL
                echo '<img src="' . $randomPhoto . '" class="rounded-circle ml-2" alt="Random Photo">';
            }
            ?>
        </span>
    </div>
</nav>
