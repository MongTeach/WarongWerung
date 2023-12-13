<!-- delete_reservation.php -->

<?php
include "../koneksi.php";

// Initialize variables for alert
$alert_type = '';
$alert_message = '';

// Handle deletion if the booking_id is provided
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Delete reservation from the database
    $sql_delete = "DELETE FROM booking WHERE booking_id = $booking_id";

    if ($conn->query($sql_delete) === TRUE) {
        // Set success alert parameters
        $alert_type = 'success';
        $alert_message = 'Reservation deleted successfully!';
    } else {
        // Set error alert parameters
        $alert_type = 'error';
        $alert_message = "Error deleting record: " . $conn->error;
    }
} else {
    // Set error alert parameters for invalid request
    $alert_type = 'error';
    $alert_message = 'Invalid request. Please provide a booking_id for deletion.';
}

// Redirect back to index.php with alert parameters
header("Location: reservation_history.php?alert_type=$alert_type&alert_message=$alert_message");
exit();

$conn->close();
?>
