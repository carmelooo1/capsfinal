<?php

include("conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/xampp/htdocs/capstone/vendor/autoload.php';

require '/xampp/htdocs/capstone/vendor/phpmailer/phpmailer/src/Exception.php';
require '/xampp/htdocs/capstone/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/xampp/htdocs/capstone/vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ui_library";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];

    $sql = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_id = $row["id"];

        $new_password = generateRandomPassword(8); 
        $encrypted_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql_update = "UPDATE students SET password = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $encrypted_password, $student_id);
        if ($stmt_update->execute()) {
            sendEmail($email, "Password Reset", "Your new password is: $new_password");
            echo '<script>alert("Password reset successful. Check your email for the new password."); window.location.href = "index.php";</script>';
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM teachers WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $teacher_id = $row["id"];

            $new_password = generateRandomPassword(8); // Generate a random password
            $encrypted_password = password_hash($new_password, PASSWORD_DEFAULT);

            $sql_update = "UPDATE teachers SET password = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $encrypted_password, $teacher_id);
            if ($stmt_update->execute()) {
                sendEmail($email, "Password Reset", "Your new password is: $new_password");
                echo '<script>alert("Password reset successful. Check your email for the new password."); window.location.href = "index.php";</script>';
                exit;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Email not found.";
        }
    }

    $conn->close();
}

function sendEmail($to, $subject, $message)
{
    $mail = new PHPMailer(true);

    $smtpUsername = "uiphinmalibrary@gmail.com";
    $smtpPassword = "wkalxolfdxcgwtox";
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipient
        $mail->setFrom($smtpUsername, 'Hello user');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo 'Password reset email sent successfully.';
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}

function generateRandomPassword($length) {
    $digits = '0123456789';
    $lowercaseLetters = 'abcdefghijklmnopqrstuvwxyz';
    $uppercaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    $password = '';
    $password .= $digits[rand(0, strlen($digits) - 1)];
    $password .= $lowercaseLetters[rand(0, strlen($lowercaseLetters) - 1)];
    $password .= $uppercaseLetters[rand(0, strlen($uppercaseLetters) - 1)];
    for ($i = 0; $i < $length - 3; $i++) {
        $password .= $lowercaseLetters[rand(0, strlen($lowercaseLetters) - 1)];
    }
    $password = str_shuffle($password);

    return $password;
}


?>
