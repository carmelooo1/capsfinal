<?php
include('conn.php');

if(isset($_POST['id_number'])) {
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);

    $query = "SELECT * FROM teachers WHERE id_number = '$id_number'";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
        echo json_encode($student);
    } else {
        echo json_encode(array('error' => 'No teacher found with the provided ID number.'));
    }
} else {
    echo json_encode(array('error' => 'ID teacher parameter is missing.'));
}


