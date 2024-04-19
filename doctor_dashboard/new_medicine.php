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

    if (isset($_POST['submit_medicine'])) {
        $new_diagnosis_id = $_POST['add_medicine_diagnosis'];
        $new_patient_id = $_POST['add_medicine_patient'];
        $new_name = $_POST['add_medicine_name'];
        $new_prescription = $_POST['add_medicine_prescription'];
        $med_insert_query = "INSERT INTO Medicine (Diagnosis_ID, Doctor_ID, Patient_ID, Medicine_Name, Medicine_Prescription) VALUES ('$new_diagnosis_id', '{$_SESSION['doctor_id']}', '$new_patient_id', '$new_name', '$new_prescription')";

        if (mysqli_query($conn, $med_insert_query)) {
            header("Location: doctor_dashboard_medicines.php");
            exit();
        } else {
            echo "Error adding a record: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding a new medicine - Dashboard</title>
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
            <h2 class="mb-4">Adding a new medicine</h2>
            <div id="add_medicine">
                <form method="POST" action="new_medicine.php">
                    <label for="add_medicine_diagnosis" class="form-label">Diagnosis number:</label>
                    <input type="text" name="add_medicine_diagnosis" class="form-control" id="add_medicine_diagnosis" required>
                    <label for="add_medicine_patient" class="form-label mt-2">Patient number:</label>
                    <input type="text" name="add_medicine_patient" class="form-control" id="add_medicine_patient" required>
                    <label for="add_medicine_name" class="form-label mt-2">Medicine name:</label>
                    <input type="text" name="add_medicine_name" class="form-control" id="add_medicine_name" required>
                    <label for="add_medicine_prescription" class="form-label mt-2">Medicine prescription:</label>
                    <textarea type="text" name="add_medicine_prescription" class="form-control" id="add_medicine_prescription" required></textarea>
                    <input type="submit" value="Save" name="submit_medicine" class="btn btn-primary mt-4">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
