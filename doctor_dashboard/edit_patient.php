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

        $query = "SELECT * FROM Patient WHERE Patient_ID = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
    }

    if (isset($_POST['submit_patient_changes'])) {
        $new_first_name = $_POST['change_patient_firstname'];
        $new_last_name = $_POST['change_patient_lastname'];
        $new_photo_url = $_POST['change_patient_photo_url'];
        $new_birthday = $_POST['change_patient_birthday'];
        $new_gender = $_POST['change_patient_gender'];
        $new_address = $_POST['change_patient_address'];
        $new_phone = $_POST['change_patient_phone'];
        $new_email = $_POST['change_patient_email'];
        $new_password = $_POST['change_patient_password'];
        if (empty($new_password)) {
            $pat_update_query = "UPDATE Patient SET First_Name = '$new_first_name', Last_Name = '$new_last_name', Photo_Url = '$new_photo_url', Birthday = '$new_birthday', Gender = '$new_gender', Address = '$new_address', Phone = '$new_phone', Email = '$new_email' WHERE Patient_ID = $id";
        } else {
            $pat_update_query = "UPDATE Patient SET First_Name = '$new_first_name', Last_Name = '$new_last_name', Photo_Url = '$new_photo_url', Birthday = '$new_birthday', Gender = '$new_gender', Address = '$new_address', Phone = '$new_phone', Email = '$new_email', Password = SHA2('$new_password', 256) WHERE Patient_ID = $id";
        }

        if (mysqli_query($conn, $pat_update_query)) {
            header("Location: doctor_dashboard_my_patients.php");
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
    <title>Changing patient - Dashboard</title>
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
                <a href="doctor_dashboard_my_patients.php" class="nav-link active d-flex align-items-center" id="receptions-link">
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
        <div class="px-4 py-5">
            <h2 class="mb-4">Changing patient No.<?php echo $row['Patient_ID']; ?></h2>
            <div id="change_patient">
                <form method="POST" action="edit_patient.php?id=<?php echo $row['Patient_ID']; ?>">
                    <label for="change_patient_firstname" class="form-label">Patient's first name:</label>
                    <input type="text" name="change_patient_firstname" class="form-control" id="change_patient_firstname" value="<?php echo $row['First_Name']; ?>" required>
                    <label for="change_patient_lastname" class="form-label mt-2">Patient's last name: </label>
                    <input type="text" name="change_patient_lastname" class="form-control" id="change_patient_lastname" value="<?php echo $row['Last_Name']; ?>" required>
                    <label for="change_patient_photo_url" class="form-label mt-2">Patient's photo URL: </label>
                    <input type="text" name="change_patient_photo_url" class="form-control" id="change_patient_photo_url" value="<?php echo $row['Photo_Url']; ?>" required>
                    <label for="change_patient_birthday" class="form-label mt-2">Birthday: </label>
                    <input type="date" name="change_patient_birthday" class="form-control" pattern="^\d{4}-\d{2}-\d{2}$" id="change_patient_birthday" value="<?php echo $row['Birthday']; ?>" required>
                    <label for="change_patient_gender" class="form-label mt-2">Gender: </label>
                    <input type="text" name="change_patient_gender" class="form-control" id="change_patient_gender" value="<?php echo $row['Gender']; ?>" required>
                    <label for="change_patient_address" class="form-label mt-2">Address: </label>
                    <input type="text" name="change_patient_address" class="form-control" id="change_patient_address" value="<?php echo $row['Address']; ?>" required>
                    <label for="change_patient_phone" class="form-label mt-2">Phone: </label>
                    <input type="text" name="change_patient_phone" class="form-control" pattern="^\+(?:[0-9] ?){6,14}[0-9]$" id="change_patient_phone" value="<?php echo $row['Phone']; ?>" required>
                    <label for="change_patient_email" class="form-label mt-2">Email: </label>
                    <input type="email" name="change_patient_email" class="form-control" id="change_patient_email" value="<?php echo $row['Email']; ?>" required>
                    <label for="change_patient_password" class="form-label mt-2">Password: </label>
                    <input type="password" name="change_patient_password" class="form-control" id="change_patient_password">
                    <input type="submit" value="Save" name="submit_patient_changes" class="btn btn-primary mt-4">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
