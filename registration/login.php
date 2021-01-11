<?php
include("../connect.php");
session_start();
if (isset($_SESSION["loggedin"])) {
    header("location:user.php");
    exit;
}

$student_reg_id = $_SESSION['student_reg_id'];
echo '<script> alert("Your student_id might be '.$student_reg_id.'") </script>';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST["student_id"];
    $password = $_POST["password"];

    $sql = "select * from student where student_id='$student_id' ";
    $sql1 = "select * from numbers where student_id='$student_id' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $res = mysqli_fetch_array($result);
        $hash = $res['password'];
        if (password_verify($password, $hash)) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["student_id"] = $student_id;
            $_SESSION["fname"] = $res['fname'];
            $_SESSION["lname"] = $res['lname'];
            $_SESSION["type"] = $res["class_type"];
            header("location:user.php");
        } else
            echo '<script> alert("Error with number or password") </script>';
    } else {
        echo '<script> alert("Error with number or password") </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Login</title>
</head>

<body>
    <div class="container" style="margin-top: 1%;">
        <div class="row col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Login form</h1>
                </div>
                <div class=" panel-body">
                    <form action="login.php" method="POST">

                        <div class="form-group">
                            <label for="student_id">Student id</label>
                            <input type="text" class="form-control" name="student_id" id="student_id" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>

                        <input type="submit" value="submit" class="btn btn-primary">
                    </form>
                </div>
                <div class=" panel-footer text-right">
                    <small>&copy; technical</small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>