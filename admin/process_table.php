<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            $table_number = $_POST['table_number'];
            $table_type = $_POST['table_type'];

            $sql = "INSERT INTO tables (table_number, table_type) VALUES ('$table_number', '$table_type')";

            if ($conn->query($sql) === TRUE) {
                header("Location: table.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            break;
        case 'edit':
            $table_id = $_POST['table_id'];
            $table_number = $_POST['table_number'];
            $table_type = $_POST['table_type'];

            $sql = "UPDATE tables SET table_number='$table_number', table_type='$table_type' WHERE table_id='$table_id'";

            if ($conn->query($sql) === TRUE) {
                header("Location: table.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            break;
    }

} else {
    header("Location: table.php");
}

$conn->close();
?>
