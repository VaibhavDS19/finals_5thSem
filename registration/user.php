<?php
include("../connect.php");
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("location:login.php");
}

$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$student_id = $_SESSION['student_id'];
$type = $_SESSION['type'];

if ($type == "CET") {
    $sql = "SELECT * FROM TEACHER WHERE type='CET'";
    $marks = "SELECT * FROM CET WHERE student_id = '$student_id'";
} else {
    $sql = "SELECT * FROM TEACHER WHERE type='JEE'";
    $marks = "SELECT * FROM JEE WHERE student_id = '$student_id'";
}
$res = mysqli_query($link, $sql);
$marks_list = mysqli_query($link, $marks);
$sum = 0;
$highest = 0;
$average = 0;
$no_of_tests = mysqli_num_rows($marks_list);
while ($x = mysqli_fetch_array($marks_list)) {
    $sum += $x['marks'];
    if ($x['marks'] > $highest) $highest = $x['marks'];
}

if ($no_of_tests > 0) {
    $average = $sum / $no_of_tests;
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
            margin: 10%;
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
                <a class="navbar-brand  em-text" href="#"> <?php echo $fname . " " . $lname; ?> </a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="transactions.php">Payment</a></li>
                    <li class="active"><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="quartz">
        <div class=" panel-body">
            <p> <b> You have taken <?php echo $no_of_tests; ?> test<?php if ($no_of_tests > 1) echo 's'; ?> </b> </p> <br> <br>
            <p> Highest score: <?php echo $highest; ?> </p> <br> <br>
            <p> Average score: <?php echo $average; ?> </p> <br> <br>

            <ul>
                <?php
                while ($x = (mysqli_fetch_array($res))) {
                ?>
                    <li> <?php echo "Prof. " . $x['first_name'] . ' ' . $x['last_name'] . ' - (' . $x['subject'] . ')' ?> <br>
                        <?php echo 'Number- ' . $x['number'] ?> <br>
                        <?php echo 'Email: ' . $x['email']; ?> <br> <br>
                        <hr>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</body>

</html>