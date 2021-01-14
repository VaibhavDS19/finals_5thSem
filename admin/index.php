<?php
include("../connect.php");
session_start();
if (!isset($_SESSION['loggedin_admin'])) {
    header("location:login.php");
}
$aname = $_SESSION['aname'];
$aid = $_SESSION['aid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pid = $_POST['person_id'];
    if (isset($pass['person_type'])) {
        $ptype = $_POST['person_type'];
        $pass = $_POST['password'];
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        if ($ptype == "TEACHER" || $ptype == "STUDENT" || ($ptype == "ADMIN" && ($pid == $aid))) {
            if ($ptype == "TEACHER") {
                $sql = "UPDATE TEACHER SET password = '$pass' WHERE teacher_id = '$pid'";
            } else if ($ptype == "STUDENT") {
                $sql = "UPDATE STUDENT SET password = '$pass' WHERE student_id = '$pid'";
            } else {
                $sql = "UPDATE ADMIN SET password = '$pass' WHERE admin_id = '$pid'";
            }
            if (mysqli_query($link, $sql)) {
                echo '<script> alert("Password updated successfully.") </script>';
            } else {
                echo '<script> alert("Encountered unknown error while changing the password.") </script>';
            }
        } else {
            echo '<script> alert("Wrong person_type or person_id provided, please check again.") </script>';
        }
    } else {
        $ptype = $_POST['person_type_del'];
        if ($ptype == "TEACHER") {
            $sql = "DELETE FROM teacher WHERE teacher_id = '$pid'";
            if (mysqli_query($link, $sql)) {
                echo '<script> alert("Successful query") </script>';
            } else {
                echo '<script> alert("Unsuccessful query") </script>';
            }
        } else if ($ptype == 'STUDENT') {
            $sql = "DELETE FROM student WHERE student_id = '$pid'";

            if (mysqli_query($link, $sql)) {
                echo '<script> alert("Successful query") </script>';
            } else {
                echo '<script> alert("Unsuccessful query") </script>';
            }
        }
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
    <link rel="stylesheet" href="modify.css">
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
            <div id='password_change'>
                <p>CHANGE PASSWORD</p>
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <label for="person_type">Person type (student/teacher/admin in all caps) to change password</label>
                        <input type="text" class="form-control" name="person_type" id="person_type" required>
                    </div>
                    <div class="form-group">
                        <label for="person_id">Person id</label>
                        <input type="text" class="form-control" name="person_id" id="person_id" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New password</label>
                        <input type="text" class="form-control" name="password" id="password" required>
                    </div>
                    <input type="submit" value="submit" class="btn btn-primary">
                </form>
            </div>

            <div id='deletes'>
                <p>DELETE USER</p>
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <label for="person_type_del">Person type (student/teacher in all caps) to delete</label>
                        <input type="text" class="form-control" name="person_type_del" id="person_type_del" required>
                    </div>
                    <div class="form-group">
                        <label for="person_id">Person id</label>
                        <input type="text" class="form-control" name="person_id" id="person_id" required>
                    </div>
                    <input type="submit" value="delete" class="btn btn-primary">
                </form>
            </div>

            <div class="form-group">
                <button id="btn1" onclick="password()">Password change</button>
                <button id="btn2" onclick="del()">Delete student/teacher</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function password() {
            let pass = document.getElementById('password_change');
            pass.style.display = 'block';
            let dels = document.getElementById("deletes");
            dels.style.display = 'none';
        }

        function del() {
            let dels = document.getElementById("deletes");
            dels.style.display = 'block';
            let pass = document.getElementById('password_change');
            pass.style.display = 'none';
        }
    </script>
</body>

</html>