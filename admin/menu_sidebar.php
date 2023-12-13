<?php
include "session.php";
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon ">
            <img src="img/unsrat.png" width="45px" height="60px" alt="...">
        </div>
        <div class="sidebar-brand-text mx-3">WarongWerung</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="table.php">
            <i class="fas fa-table"></i>
            <span>Manage Table</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="reservation_data.php">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Reservation Data</span>
        </a>
    </li>

    <?php
    // Check if the user is a manager to decide whether to show "Reservation History"
    if ($_SESSION['role'] == 'manajer') {
        echo '<li class="nav-item">
                  <a class="nav-link" href="reservation_history.php">
                      <i class="fas fa-history"></i>
                      <span>Reservation History</span>
                  </a>
              </li>';
    }
    ?>
    <?php
    // Check if the user is a manager to decide whether to show "Reservation History"
    if ($_SESSION['role'] == 'manajer') {
        echo '<li class="nav-item">
                  <a class="nav-link" href="setting.php">
                      <i class="fas fa-cog"></i>
                      <span>Setting</span>
                  </a>
              </li>';
    }
    ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
