<?php
include "conn.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_number'])) {
        $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);

        $delete_query = "DELETE FROM teachers WHERE id_number = '$id_number'";
        $result = mysqli_query($conn, $delete_query);

        if ($result) {
            // Record deleted successfully
            echo "Record deleted successfully from teacher table. ";
            // Alert
            echo "<script>alert('Record deleted successfully from teacher table.');</script>";
        } else {
            // Error deleting record
            echo "Error deleting record from teacher table: " . mysqli_error($conn);
        }
    } else {
        // ID Number parameter is missing
        http_response_code(400);
        echo "ID Number parameter is missing.";
    }
} else {
    // Only POST requests are allowed
    http_response_code(405);
    echo "Only POST requests are allowed.";
}
?>
