<?php
include("../connect.php");
session_start();
if (!isset($_SESSION["loggedin_teacher"])) {
    header("location:login.php");
    exit;
}
$teacher_name = $_SESSION['tname'];
$cttype = $_SESSION['cttype'];
$subject = $_SESSION['subject'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test = intval($_POST['test']);
    $student_id = $_POST['student_id'];
    $marks = intval($_POST['marks']);
    $stu_type = "SELECT class_type FROM student where student_id = '$student_id'";
    $res = mysqli_query($link, $stu_type);

    if ($res && mysqli_num_rows($res) > 0) {
        $st_type = mysqli_fetch_array($res);
        $sttype = $st_type['class_type'];
        if ($cttype == "CET") {
            if ($sttype == "CET") {
                $insert = "INSERT INTO cet VALUES ('$test','$subject','$student_id','$marks')";
                if (mysqli_query($link, $insert))
                    echo '<script> alert("added marks") </script>';
                else
                    echo '<script> alert("Student marks already entered for this student.") </script>';
            } else {
                echo '<script> alert("Wrong student id. Student is not from CET batch.") </script>';
            }
        } else {
            if ($sttype == "JEE") {
                $insert = "INSERT INTO jee VALUES ('$test','$subject','$student_id','$marks')";
                if (mysqli_query($link, $insert))
                    echo '<script> alert("added marks") </script>';
                else
                    echo '<script> alert("Student marks already exists for this student.") </script>';
            } else {
                echo '<script> alert("Wrong student id. Student is not from JEE batch.") </script>';
            }
        }
    } else {
        echo '<script> alert("No such student.") </script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../common_styles.css">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <style>
        #quartz {
            margin: 15%;
            color: black;
            background-color: blanchedalmond;
            border: 5px solid gold;
            text-align: center;
        }

        button {
            color: #ffffff;
            width: 100%;
            background-color: green;
        }

        p {
            width: 100%;
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
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#"><?php echo $teacher_name;?></a></li>
                    <li class="active"><a href="index.php">Home</a></li>
                    <li class="active"><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="quartz">
        <div class=" panel-body">
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="test">Test number</label>
                    <input type="number" class="form-control" name="test" id="test">
                </div>
                <div class="form-group">
                    <label for="student_id">student_id</label>
                    <input type="text" class="form-control" name="student_id" id="student_id">
                </div>
                <div class="form-group">
                    <label for="marks">Marks</label>
                    <input type="number" class="form-control" name="marks" id="marks">
                </div>
                <input type="submit" value="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</body>

</html>