<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conn.php";

    // Debugging: Log received POST data
    error_log(print_r($_POST, true));

    if (isset($_POST['updateteacherId']) && isset($_POST['updateteacherIdNumber']) && isset($_POST['updateteacherFirstName']) && isset($_POST['updateteacherLastName']) && isset($_POST['updateteacherEmail'])) {

        // input data to prevent SQL injection
        $teacherId = mysqli_real_escape_string($conn, $_POST['updateteacherId']);
        $id_number = mysqli_real_escape_string($conn, $_POST['updateteacherIdNumber']);
        $firstName = mysqli_real_escape_string($conn, $_POST['updateteacherFirstName']);
        $lastName = mysqli_real_escape_string($conn, $_POST['updateteacherLastName']);
        $email = mysqli_real_escape_string($conn, $_POST['updateteacherEmail']);

        $sql = "UPDATE teachers SET id_number='$id_number', fname='$firstName', lname='$lastName', email='$email' WHERE id='$teacherId'";

        if (mysqli_query($conn, $sql)) {
            echo "Teacher details updated successfully!";
        } else {
            echo "Error updating teacher details: " . mysqli_error($conn);
        }
    } else {
        echo "All required fields are not set!";
    }

    mysqli_close($conn);
} else {
    header("Location: error.php");
    exit();
}
?>
