<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $table_id = $_GET['id'];

    $delete_table_sql = "DELETE FROM tables WHERE table_id='$table_id'";

    if ($conn->query($delete_table_sql) === TRUE) {
        header("Location: table.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: table.php");
}

$conn->close();
?>
