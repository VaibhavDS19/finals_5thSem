<?php
include("../connect.php");
session_start();
if (isset($_SESSION["loggedin_admin"]) && $_SESSION["loggedin_admin"] == true) {
    header("location:index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $admin_id = $_POST["admin_id"];
    $password = $_POST["password"];

    $sql = "select * from admin where admin_id='$admin_id' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $res = mysqli_fetch_array($result);
        $hash = $res['password'];
        if (password_verify($password, $hash)) {
            session_start();
            $_SESSION["loggedin_admin"] = true;
            $_SESSION["aid"] = $admin_id;
            $_SESSION["aname"] = $res['admin_name'];
            $_SESSION["class_type"] = $res["class_type"];
            echo '<script> alert("'.$_SESSION['aname'].'") </script>';
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
                    <h1>Login admin</h1>
                </div>
                <div class=" panel-body">
                    <form action="login.php" method="POST">

                        <div class="form-group">
                            <label for="admin_id">Admin id</label>
                            <input type="text" class="form-control" name="admin_id" id="admin_id" required>
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