<?php
include("../connect.php");
session_start();
if (isset($_SESSION["loggedin_teacher"])) {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $teacher_id = $_POST["teacher_id"];
    $password = $_POST["password"];

    $sql = "select * from teacher where teacher_id='$teacher_id' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $res = mysqli_fetch_array($result);
        $hash = $res['password'];
        if (password_verify($password, $hash)) {
            session_start();
            $_SESSION["loggedin_teacher"] = true;
            $_SESSION["teacher_id"] = $teacher_id;
            $_SESSION["tname"] = $res['first_name'] . " " . $res['last_name'];
            $_SESSION["cttype"] = $res["type"];
            $_SESSION["subject"] = $res["subject"];
            header("location:index.php");
        } else {
            echo '<script> alert("Error with password") </script>';
        }
    } else {
        echo '<script> alert("Error with id or password") </script>';
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
                    <h1>Login teacher</h1>
                </div>
                <div class=" panel-body">
                    <form action="login.php" method="POST">

                        <div class="form-group">
                            <label for="teacher_id">teacher id</label>
                            <input type="text" class="form-control" name="teacher_id" id="teacher_id" required>
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