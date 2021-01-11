<?php
include("../connect.php");
session_start();
if (!isset($_SESSION['loggedin_admin'])) {
    header("location:login.php");
}
$aname = $_SESSION['aname'];
$aid = $_SESSION['aid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ptype = $_POST['person_type'];
    $pid = $_POST['person_id'];
    $pass = $_POST['password'];
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    if ( $ptype == "TEACHER" || $ptype == "STUDENT" || ($ptype == "ADMIN" && ($pid == $aid)) ) {
        if ($ptype == "TEACHER") {
            $sql = "UPDATE TEACHER SET password = '$pass' WHERE teacher_id = '$pid'";
        } else if ($ptype == "STUDENT") {
            $sql = "UPDATE STUDENT SET password = '$pass' WHERE student_id = '$pid'";
        } else {
            $sql = "UPDATE ADMIN SET password = '$pass' WHERE admin_id = '$pid'";
        }
        if(mysqli_query($link,$sql)) {
            echo '<script> alert("Password updated successfully.") </script>';
        } else {
            echo '<script> alert("Encountered unknown error while changing the password.") </script>';
        }
    } else {
        echo '<script> alert("Wrong person_type or person_id provided, please check again.") </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        button {
            color: #ffffff;
            width: 100%;
            background-color: green;
        }

        p {
            width: 100%;
        }

        .panel-body {
            margin: 15%;
            border: 5px solid black;
            background-color: gold;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"> <?php echo $aname; ?> </a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Refresh home page</a></li>
                    <li class="active"><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="panel panel-primary">
        <div class=" panel-body">
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="person_type">Person type (student/teacher/admin in all caps) to change password</label>
                    <input type="text" class="form-control" name="person_type" id="person_type">
                </div>
                <div class="form-group">
                    <label for="person_id">Person id</label>
                    <input type="text" class="form-control" name="person_id" id="person_id">
                </div>
                <div class="form-group">
                    <label for="password">New password</label>
                    <input type="text" class="form-control" name="password" id="password">
                </div>
                <input type="submit" value="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</body>

</html>