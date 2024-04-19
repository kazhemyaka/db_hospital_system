<?php
    session_start();
    if (!isset($_SESSION['doctor_email'])){
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

    $query = "SELECT * FROM Doctor WHERE Doc_Email = '{$_SESSION['doctor_email']}'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['submit_phone'])) {
        $phone_number = $_POST['phone_number'];

        $phone_update_query = "UPDATE Doctor SET Doc_Phone = '$phone_number' WHERE Doc_Email = '{$_SESSION['doctor_email']}'";

        if (mysqli_query($conn, $phone_update_query)) {
            header("Refresh:0");
            exit();
        } else {
            echo "Error updating phone number: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['submit_email'])) {
        $email = $_POST['email'];

        $email_update_query = "UPDATE Doctor SET Doc_Email = '$email' WHERE Doc_Email = '{$_SESSION['doctor_email']}'";

        if (mysqli_query($conn, $email_update_query)) {
            $_SESSION['doctor_email'] = $email;
            header("Refresh:0");
            exit();
        } else {
            echo "Error updating email: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['submit_password'])) {
        $password = $_POST['password'];

        $password_update_query = "UPDATE Doctor SET Doc_Password = SHA2('$password', 256) WHERE Doc_Email = '{$_SESSION['doctor_email']}'";

        if (mysqli_query($conn, $password_update_query)) {
            header("Refresh:0");
            exit();
        } else {
            echo "Error updating password: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Dashboard</title>
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
            <div class="px-4 py-5 my-5 text-center">
                <img src="<?php echo $_SESSION['photo_url']; ?>" alt="profile photo" class="rounded-circle me-2 mb-3" width="128" height="128">
                <h1 class="flex-wrap"><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></h1>
                <div class="container text-center">
                    <div class="row mt-5">
                        <div class="col-lg-4 col-md-12 mt-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Speciality:</h4>
                                    <p class="card-text"><?php echo $row['Speciality'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 mt-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Your phone number:</h4>
                                    <p class="card-text"><?php echo $row['Doc_Phone'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 mt-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Your email:</h4>
                                    <p class="card-text"><?php echo $row['Doc_Email'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mx-auto mt-5">
                        <a class="btn btn-primary btn-lg px-4 gap-3 mt-1" href="" role="button" onclick="showPhoneNumberForm()">Change phone number</a>
                        <a class="btn btn-primary btn-lg px-4 gap-3 mt-1" href="" role="button" onclick="showEmailForm()">Change email</a>
                        <a class="btn btn-primary btn-lg px-4 gap-3 mt-1" href="" role="button" onclick="showPasswordForm()">Change password</a>
                    </div>
                    <div id="phone_number_form" class="mt-5" style="display: none">
                        <form method="POST" action="doctor_dashboard_profile.php">
                            <label for="phone_number" class="form-label">New phone number:</label>
                            <input type="text" pattern="^\+(?:[0-9] ?){6,14}[0-9]$" name="phone_number" class="form-control" id="phone_number" required>
                            <input type="submit" value="Save" name="submit_phone" class="btn btn-primary mt-2">
                        </form>
                    </div>
                    <div id="email_form" class="mt-5" style="display: none">
                        <form method="POST" action="doctor_dashboard_profile.php">
                            <label for="email" class="form-label">New email:</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                            <input type="submit" value="Save" name="submit_email" class="btn btn-primary mt-2">
                        </form>
                    </div>
                    <div id="password_form" class="mt-5" style="display: none">
                        <form method="POST" action="doctor_dashboard_profile.php">
                            <label for="password" class="form-label">New password:</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                            <input type="submit" value="Save" name="submit_password" class="btn btn-primary mt-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>


