<?php
include("../connect.php");
session_start();
if (!isset($_SESSION["student_id"])) {
    header("location:login.php");
}
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$student_id = $_SESSION['student_id'];
$type = $_SESSION['type'];

if ($type == 'CET') $cost = 'Rs 10,000';
else $cost = 'Rs 12,000';

$sql = "SELECT * FROM transactions WHERE student_id = '$student_id'";
$res = mysqli_query($link, $sql);

if (mysqli_num_rows($res) > 0) {
    $message = "Already paid. You can go back to user page.";
    echo '<script> alert("Already paid.")</script> ';
} else {
    echo '<script> alert("Payment amount is ' . $cost . ' ") </script> ';
    $date_transaction = getdate();
    $date = $date_transaction['year'] . '-' . (intval($date_transaction['month']) + 1) . '-' . $date_transaction['mday'];
    $insert = "INSERT INTO transactions VALUES('$student_id', '$type', '$date')";
    $res2 = mysqli_query($link, $insert);
    if ($res2) {
        $message = "You have paid fees successfully.  Click on home page to go to user page.";
        echo '<script> alert("You have paid fees successfully.") </script>';
    } else {
        $message = "Unsuccessful payment. Please click on home page to go back to homescreen.";
        echo '<script> alert("Unsuccessful payment.") </script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <style>
        #quartz {
            margin: 10%;
            color: black;
            background-color: blanchedalmond;
            border: 5px solid gold;
            text-align: center;
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
                    <li class="active"><a href="user.php">Home page</a></li>
                    <li class="active"><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="quartz">
        <div class=" panel-body">
            <h3>
                <?php echo $message; ?>
            </h3>
        </div>
    </div>
</body>

</html>