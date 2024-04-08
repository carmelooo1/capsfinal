<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["import"])) {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $csv_data = array_map('str_getcsv', file($_FILES["file"]["tmp_name"]));

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO books (barcode, call_no1, call_no2, copyright, title, author, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $barcode, $call_no1, $call_no2, $copyright, $title, $author, $location);

        foreach ($csv_data as $row) {
            list($barcode, $call_no1, $call_no2, $copyright, $title, $author, $location) = $row;
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();
        
        echo '<script>alert("CSV FILE SUCCESSFULLY UPLOADED.");</script>';
        echo '<script>window.location.href = "'.$_SERVER['HTTP_REFERER'].'";</script>';
    } else {
        echo '<script>alert("CSV FILE ERROR UPLOADING.");</script>';
        echo '<script>window.location.href = "'.$_SERVER['HTTP_REFERER'].'";</script>';
        exit();
    }
}
?>
