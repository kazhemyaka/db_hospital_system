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

    $query = "SELECT Medicine_ID, Diagnosis_ID, Patient.Photo_Url, CONCAT(Patient.First_Name, ' ', Patient.Last_Name) AS Patient_Name, Medicine_Name, Medicine_Prescription, Treatment_Date FROM Medicine JOIN Patient ON Medicine.Patient_ID = Patient.Patient_ID WHERE Doctor_ID = " . $_SESSION['doctor_id'];
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicines - Dashboard</title>
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
                    <a href="#" class="nav-link active d-flex align-items-center align-content-center">
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
            <div class="px-4 py-5 my-5">
                <h1>
                    Medicines
                    <a class="btn btn-primary ms-2" href="new_medicine.php"><i class="bi bi-capsule-pill me-2"></i>New medicine</a>
                </h1>
                <table class="table mt-5" id="table-patients">
                    <thead>
                        <tr>
                            <th>Medicine number</th>
                            <th>Diagnosis number</th>
                            <th>Photo</th>
                            <th>Patient</th>
                            <th>Medicine name</th>
                            <th>Medicine prescription</th>
                            <th>Date of treatment</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['Medicine_ID']; ?></td>
                                <td><?php echo $row['Diagnosis_ID']; ?></td>
                                <td><img src="<?php echo $row['Photo_Url']; ?>" class="rounded-circle me-2" width="32" height="32"></td>
                                <td><?php echo $row['Patient_Name']; ?></td>
                                <td><?php echo $row['Medicine_Name'] ?></td>
                                <td><?php echo $row['Medicine_Prescription'] ?></td>
                                <td><?php echo $row['Treatment_Date'] ?></td>
                                <td>
                                    <a class="btn btn-primary me-2 mb-1" href="edit_medicine.php?id=<?php echo $row['Medicine_ID']; ?>" role="button"><i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-primary" id="delete-btn" href="delete_medicine.php?id=<?php echo $row['Medicine_ID']; ?>" role="button"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>