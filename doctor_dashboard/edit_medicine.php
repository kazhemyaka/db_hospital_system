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

        $query = "SELECT * FROM Medicine WHERE Medicine_ID = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
    }

    if (isset($_POST['submit_medicine_changes'])) {
        $new_name = $_POST['change_medicine_name'];
        $new_prescription = $_POST['change_medicine_prescription'];
        $new_date = $_POST['change_medicine_date'];
        $med_update_query = "UPDATE Medicine SET Medicine_Name = '$new_name', Medicine_Prescription = '$new_prescription', Treatment_Date = '$new_date' WHERE Medicine_ID = $id";

        if (mysqli_query($conn, $med_update_query)) {
            header("Location: doctor_dashboard_medicines.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changing medicine - Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="shortcut icon" href="../photos_for_index/logo_hospital.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="d-flex flex-nowrap">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark min-vh-100">
        <a href="../index.html" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="../photos_for_index/logo_hospital.png" alt="logo" width="32" height="32" class="me-2 ms-2">
            <span class="fs-4 d-none d-md-block d-lg-block d-xl-block d-xxl-block">Hospital System</span>
        </a>
        <hr>
        <ul class="nav nav-pills mb-sm-auto mb-0 flex-column">
            <li class="nav-item">
                <a href="doctor_dashboard.php" class="nav-link text-white d-flex align-items-center" id="home-link">
                    <i class="bi bi-house me-2"></i>
                    <span class="d-none d-md-block d-lg-block d-xl-block d-xxl-block">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="doctor_dashboard_all_patients.php" class="nav-link text-white d-flex align-items-center" id="receptions-link">
                    <i class="bi bi-person-circle me-2"></i>
                    <span class="d-none d-md-block d-lg-block d-xl-block d-xxl-block">All patients</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="doctor_dashboard_my_patients.php" class="nav-link text-white d-flex align-items-center" id="receptions-link">
                    <i class="bi bi-person-circle me-2"></i>
                    <span class="d-none d-md-block d-lg-block d-xl-block d-xxl-block">My patients</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="doctor_dashboard_receptions.php" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-calendar me-2"></i>
                    <span class="d-none d-md-block d-lg-block d-xl-block d-xxl-block">Receptions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="doctor_dashboard_diagnoses.php" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-clipboard me-2"></i>
                    <span class="d-none d-md-block d-lg-block d-xl-block d-xxl-block">Diagnoses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="doctor_dashboard_medicines.php" class="nav-link active d-flex align-items-center align-content-center">
                    <i class="bi bi-capsule me-2"></i>
                    <span class="d-none d-md-block d-lg-block d-xl-block d-xxl-block">Medicines</span>
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $_SESSION['photo_url']; ?>" alt="profile photo" class="rounded-circle me-2" width="32" height="32">
                <strong class="d-none d-md-block d-lg-block d-xl-block d-xxl-block"><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" >
                <li><a class="dropdown-item" href="doctor_dashboard_profile.php">Profile</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="?logout">Sign out</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="px-4 py-5">
            <h2 class="mb-4">Changing medicine No.<?php echo $row['Medicine_ID']; ?></h2>
            <div id="change_medicine">
                <form method="POST" action="edit_medicine.php?id=<?php echo $row['Medicine_ID']; ?>">
                    <label for="change_medicine_name" class="form-label">Medicine name:</label>
                    <input type="text" name="change_medicine_name" class="form-control" id="change_medicine_name" value="<?php echo $row['Medicine_Name']; ?>" required>
                    <label for="change_medicine_prescription" class="form-label mt-2">Medicine prescription:</label>
                    <textarea type="text" name="change_medicine_prescription" class="form-control" id="change_medicine_prescription" required><?php echo $row['Medicine_Prescription']; ?></textarea>
                    <label for="change_medicine_date" class="form-label mt-2">Date of treatment:</label>
                    <input type="date" name="change_medicine_date" class="form-control" id="change_medicine_date" value="<?php echo $row['Treatment_Date']; ?>" required>
                    <input type="submit" value="Save" name="submit_medicine_changes" class="btn btn-primary mt-4">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
