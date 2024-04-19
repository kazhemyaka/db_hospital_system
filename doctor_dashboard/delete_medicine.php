<?php
    session_start();
    if (!isset($_SESSION['doctor_email'])) {
        header("Location: ../signin_doctor.php");
        exit();
    }

    if (isset($_GET['logout'])) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header("Location: ../index.html");
        exit();
    }

    $conn = mysqli_connect('localhost', 'doctor', 'doctorpassword', 'hospital');

    if (!$conn) {
        echo 'Connection failed: ' . mysqli_connect_error();
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "DELETE FROM Medicine WHERE Medicine_ID = $id";
        $result = mysqli_query($conn, $query);
        header("Location: doctor_dashboard_medicines.php");
        exit();
    }

    mysqli_close($conn);
?>