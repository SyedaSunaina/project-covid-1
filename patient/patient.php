<?php
include("../connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient</title>
</head>

<body>
    <a href="bookappointment.php"><button>Book Appointment</button></a>

    <!-- dashboard -->
    <a href="patientappointment.php">My Appointment</a>
    <?php

    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../login.php");
        exit;
    }
    ?>
</body>

</html>