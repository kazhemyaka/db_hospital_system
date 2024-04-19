<?php
    // Підключення до бази даних
    $conn = mysqli_connect('localhost', 'doctor', 'doctorpassword', 'hospital');

    // Перевірка підключення до бази даних
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Перевірка, чи була надіслана форма
    if (isset($_POST['submit'])) {
        // Отримання email та пароля з форми
        $doctor_email = $_POST['doctor_email'];
        $doctor_password = $_POST['doctor_password'];

        // Пошук користувача в базі даних
        $query = "SELECT * FROM Doctor WHERE Doc_Email = '$doctor_email' AND Doc_Password = SHA2('$doctor_password', 256)";
        $result = mysqli_query($conn, $query);

        // Перевірка, чи був знайдений користувач
        if (mysqli_num_rows($result) == 1) {
            // Успішний вхід
            session_start();
            $_SESSION['doctor_email'] = $doctor_email;

            $row = mysqli_fetch_assoc($result);
            $_SESSION['firstName'] = $row['Doc_First_Name'];
            $_SESSION['lastName'] = $row['Doc_Last_Name'];
            $_SESSION['photo_url'] = $row['Doc_Photo_Url'];
            $_SESSION['doctor_id'] = $row['Doctor_ID'];

            if (isset($_POST['remember'])) {
                setcookie('doctor_email', $doctor_email, time() + 3600 * 24 * 7);
                setcookie('doctor_password', $doctor_password, time() + 3600 * 24 * 7);
            }

            header("Location: doctor_dashboard/doctor_dashboard.php");
            exit;
        } else {
            // Невдала спроба входу
            $error = "Invalid email or password!";
        }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="photos_for_index/logo_hospital.png" type="image/x-icon">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="photos_for_index/logo_hospital.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">
                Hospital System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="signin_patient.php">Sign In for patients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Sign In for doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutus.html">About us</a>
                </li>
              </ul>
            </div>            
        </div>
    </nav>
    <div class="container py-5 h-100">
        <div class="form-signin w-100 m-auto text-center">
            <form action="signin_doctor.php" method="POST">
                <img src="photos_for_index/logo_hospital.png" alt="logo" width="70" height="70">
                <h1 class="h2 mb-3 fw-normal py-3">Sign In for doctors</h1>
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                <?php if(isset($error)) { ?><div class="alert alert-danger"><?php echo $error; ?></div><?php } ?>
                <?php if(isset($_COOKIE['doctor_email'])) { ?>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="doctor_email" value="<?php echo $_COOKIE['doctor_email']; ?>" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                <?php } else { ?>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="doctor_email" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                <?php } ?>
                <?php if(isset($_COOKIE['doctor_password'])) { ?>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="doctor_password" value="<?php echo $_COOKIE['doctor_password']; ?>" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                <?php } else { ?>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="doctor_password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                <?php } ?>
                <div class="checkbox mb-3 py-3">
                    <label>
                        <input type="checkbox" value="remember-me" name="remember">
                        Remember me
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Sign In</button>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>