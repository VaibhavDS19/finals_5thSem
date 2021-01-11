<?php
include("../connect.php");
session_start();
$sql_query = 'SELECT * FROM student';
$result = mysqli_query($link, $sql_query);
$rows = mysqli_num_rows($result) + 1;

$student_id = "STU_ID_" . strval(sprintf("%02d", $rows));
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$password = $_POST['password'];
$conf_password = $_POST['conf_password'];
$class_type = $_POST['class_type'];
$number = intval($_POST['phno']);

if ($password == $conf_password) {

    $sql_reg = "SELECT * FROM student WHERE number = '$number'";
    $res1 = mysqli_query($link, $sql_reg);
    $row1 = mysqli_num_rows($res1);

    $_SESSION['student_reg_id'] = $student_id;
    if ($row1 > 0) {
        echo '<script> alert("Phone number already registered.") </script>';
    } else {
        // Inserting student details to student table
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO student VALUES 
                    ('$firstname', '$lastname', '$student_id', '$gender', '$class_type', '$pass', '$number');";
        $res1 = mysqli_query($link, $sql);
        if ($res1) {
            header("location: login.php");
        } else {
            echo "<script> alert('Error encountered. Try again.') </script>";
        }
    }
} else {
    echo "<script> alert('Passwords do not match. Try again.') </script>";
}
