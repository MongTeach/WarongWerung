<!-- index.php -->

<?php
session_start();
include "../koneksi.php";
include "header.php";
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
 
                </div>
                <br>
                <div class="container mt-4">

                </div>
            </div>
            <?php include "footer.php"; ?>
        </div>
    </div>

</body>

</html>
