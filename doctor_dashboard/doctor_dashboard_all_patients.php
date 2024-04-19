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

    $query = "SELECT Patient.Patient_ID, Photo_Url, CONCAT(First_Name, ' ', Last_Name) AS Patient_Name, Birthday, Gender, Address, Phone, Email, CONCAT(Doctor.Doc_First_Name, ' ', Doctor.Doc_Last_Name) AS Doctor_Name, Doctor.Doc_Photo_Url FROM Patient LEFT JOIN (SELECT DISTINCT Patient_ID, Doctor_ID FROM Reception) Reception ON Patient.Patient_ID = Reception.Patient_ID LEFT JOIN Doctor ON Reception.Doctor_ID = Doctor.Doctor_ID";
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All patients - Dashboard</title>
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
                    <a href="#" class="nav-link active d-flex align-items-center" id="receptions-link">
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
                    <a href="doctor_dashboard_medicines.php" class="nav-link text-white d-flex align-items-center align-content-center">
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
                    All patients
                    <a class="btn btn-primary ms-2" href="new_patient.php"><i class="bi bi-person-plus me-2"></i>New patient</a>
                </h1>
                <table class="table mt-5" id="table-patients">
                    <thead>
                        <tr>
                            <th>Patient number</th>
                            <th>Photo</th>
                            <th>Patient</th>
                            <th>Birthday</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Doctor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['Patient_ID']; ?></td>
                                <td><img src="<?php echo $row['Photo_Url']; ?>" class="rounded-circle me-2" width="32" height="32"></td>
                                <td><?php echo $row['Patient_Name']; ?></td>
                                <td><?php echo $row['Birthday']; ?></td>
                                <td><?php echo $row['Gender']; ?></td>
                                <td><?php echo $row['Address']; ?></td>
                                <td><?php echo $row['Phone']; ?></td>
                                <td><?php echo $row['Email']; ?></td>
                                <td>
                                    <?php
                                        if (!empty($row['Doc_Photo_Url'])) {
                                            echo '<img src="' . $row['Doc_Photo_Url'] . '" class="rounded-circle me-2" width="32" height="32">';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $row['Doctor_Name']; ?></td>
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