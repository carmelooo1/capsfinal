<?php
include "conn.php";
session_start();

if (isset($_POST['update'])) {

    $ref_id = $_GET['id'];

    $fname = $_POST['update_fname'];
    $lname = $_POST['update_lname'];
    $age = $_POST['update_age'];
    $address = $_POST['update_address'];
    $bday = $_POST['update_bday'];
    $phone = $_POST['update_phone'];
    $email = $_POST['update_email'];
    $user1 = $_POST['update_user1'];
    $pass1 = $_POST['update_pass1'];

    // Hash the password
    $pass1_hashed = password_hash($pass1, PASSWORD_DEFAULT);

    $update = mysqli_query($conn, "UPDATE user SET fname='$fname', lname='$lname', age='$age', address='$address', bday='$bday', phone='$phone', email='$email', user1='$user1', pass1='$pass1_hashed' WHERE id='$ref_id'");

    if ($update == true) {
?>
        <script>
            alert("Your UPDATE is Successful!");
            window.location.href = "records.php";
        </script>
    <?php

    } else {
    ?>
        <script>
            alert("Error UPDATE\nTry Again!");
            window.location.href = "update.php?id=<?php echo $ref_id; ?>";
        </script>
        <?php
    }
} // Check if it's a teacher registration
// Check if it's a student registration
if (isset($_POST['regformstudent'])) {
    // Student registration process
    $tableName = "students";

    // Extract data from the form
    $process_id = mysqli_real_escape_string($conn, $_POST['regform_id']);
    $process_fname = mysqli_real_escape_string($conn, $_POST['regform_fname']);
    $process_lname = mysqli_real_escape_string($conn, $_POST['regform_lname']);
    $process_email = mysqli_real_escape_string($conn, $_POST['regform_email']);
    $process_password = mysqli_real_escape_string($conn, $_POST['regform_password']);
    $process_password2 = mysqli_real_escape_string($conn, $_POST['regform_password2']);
    $process_course = mysqli_real_escape_string($conn, $_POST['regform_course']);

    // Process selected year levels
    $process_year_levels = isset($_POST['regform_yearlevel']) ? implode(",", $_POST['regform_yearlevel']) : '';

    // Check if the email or ID number already exists in the database
    $checkEmailStatement = "SELECT * FROM $tableName WHERE `email`='$process_email'";
    $checkIdNumberStatement = "SELECT * FROM $tableName WHERE `id_number`='$process_id'";
    $checkEmailQuery = mysqli_query($conn, $checkEmailStatement);
    $checkIdNumberQuery = mysqli_query($conn, $checkIdNumberStatement);
    $countEmail = mysqli_num_rows($checkEmailQuery);
    $countIdNumber = mysqli_num_rows($checkIdNumberQuery);

    if ($countEmail == 0 && $countIdNumber == 0) {
        // Check if the passwords match
        if ($process_password == $process_password2) {
            // Hash the password
            $hashed_password = password_hash($process_password, PASSWORD_DEFAULT);

            // Construct the SQL insert statement
            $insertStatement = "INSERT INTO $tableName (`id_number`, `fname`, `lname`, `email`, `password`, `course`, `year_level`)
            VALUES ('$process_id', '$process_fname', '$process_lname', '$process_email', '$hashed_password', '$process_course', '$process_year_levels')";

            // Execute the insert statement
            $result = mysqli_query($conn, $insertStatement);

            if ($result) {
                // Registration successful
        ?>
                <script>
                    alert("Student registration is successful!");
                    window.location.href = "add_student.php"; // Redirect to appropriate page
                </script>
            <?php
                exit;
            } else {
                // Error in registration
            ?>
                <script>
                    alert("Error in student registration!\nTry again.");
                    window.location.href = "add_student.php"; // Redirect to appropriate page
                </script>
            <?php
            }
        } else {
            // Passwords do not match
            ?>
            <script>
                alert("Passwords do not match!\nTry again.");
                window.location.href = "add_student.php"; // Redirect to appropriate page
            </script>
        <?php
        }
    } else {
        // User with this ID number or email already exists
        ?>
        <script>
            alert("User with this ID number or email already exists!\nTry again.");
            window.location.href = "add_student.php"; // Redirect to appropriate page
        </script>
        <?php
    }
} elseif (isset($_POST['regformteacher'])) {
    // Teacher registration process
    $tableName = "teachers";

    // Extract data from the form
    $process_id = mysqli_real_escape_string($conn, $_POST['regform_id']);
    $process_fname = mysqli_real_escape_string($conn, $_POST['regform_fname']);
    $process_lname = mysqli_real_escape_string($conn, $_POST['regform_lname']);
    $process_email = mysqli_real_escape_string($conn, $_POST['regform_email']);
    $process_password = mysqli_real_escape_string($conn, $_POST['regform_password']);
    $process_password2 = mysqli_real_escape_string($conn, $_POST['regform_password2']);

    // Check if the email or ID number already exists in the database
    $checkEmailStatement = "SELECT * FROM $tableName WHERE `email`='$process_email'";
    $checkIdNumberStatement = "SELECT * FROM $tableName WHERE `id_number`='$process_id'";
    $checkEmailQuery = mysqli_query($conn, $checkEmailStatement);
    $checkIdNumberQuery = mysqli_query($conn, $checkIdNumberStatement);
    $countEmail = mysqli_num_rows($checkEmailQuery);
    $countIdNumber = mysqli_num_rows($checkIdNumberQuery);

    if ($countEmail == 0 && $countIdNumber == 0) {
        // Check if the passwords match
        if ($process_password == $process_password2) {
            // Hash the password
            $hashed_password = password_hash($process_password, PASSWORD_DEFAULT);
            // Construct the SQL insert statement for teachers
            $insertStatement = "INSERT INTO $tableName (`id_number`, `fname`, `lname`, `email`, `password`)
VALUES ('$process_id', '$process_fname', '$process_lname', '$process_email', '$hashed_password')";

            // Execute the insert statement for teachers
            $result = mysqli_query($conn, $insertStatement);

            if ($result) {
                // Registration successful
        ?>
                <script>
                    alert("Teacher registration is successful!");
                    window.location.href = "add_student.php"; // Redirect to appropriate page
                </script>
            <?php
                exit;
            } else {
                // Error in registration
            ?>
                <script>
                    alert("Error in teacher registration!\nTry again.");
                    window.location.href = "add_student.php"; // Redirect to appropriate page
                </script>
            <?php
            }
        } else {
            // Passwords do not match
            ?>
            <script>
                alert("Passwords do not match!\nTry again.");
                window.location.href = "add_student.php"; // Redirect to appropriate page
            </script>
        <?php
        }
    } else {
        // User with this ID number or email already exists
        ?>
        <script>
            alert("User with this ID number or email already exists!\nTry again.");
            window.location.href = "add_student.php"; // Redirect to appropriate page
        </script>
<?php
    }
}




// pie graph
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$attendanceSql = "SELECT course, COUNT(*) as per_day FROM attendance GROUP BY course";
$attendanceResult = $conn->query($attendanceSql);

$studentSql = "SELECT course, COUNT(*) as count FROM students GROUP BY course";
$studentResult = $conn->query($studentSql);

if ($attendanceResult->num_rows > 0) {
    $attendanceData = [['Course', 'per Day']];
    while ($attendanceRow = $attendanceResult->fetch_assoc()) {
        $attendanceData[] = [$attendanceRow['course'], (int) $attendanceRow['per_day']];
    }
} else {
    $attendanceData = [['Course', 'per Day']];
}

if ($studentResult->num_rows > 0) {
    $studentData = [['Course', 'Count']];
    while ($studentRow = $studentResult->fetch_assoc()) {
        $studentData[] = [$studentRow['course'], (int) $studentRow['count']];
    }
} else {
    $studentData = [['Course', 'Count']];
}

echo json_encode(['attendance' => $attendanceData, 'students' => $studentData]);

$conn->close();
?>