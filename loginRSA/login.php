<?php
session_start();


// Redirect ke registrasi.php jika sudah login
if (isset($_SESSION["user"])) {
    header("Location: registrasi.php");
    exit();
}

require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["login"])) {
    // Validasi input
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"];

    if (!$email || empty($password)) {
        echo "<div class='alert alert-danger'>Email atau password tidak valid.</div>";
    } else {
        // Pencegahan SQL Injection
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user["password"])) {
                // Simpan informasi kunci dan email ke dalam session
                $emailPrefix = strstr($user["email"], '@', true);
                $_SESSION["user"] = [
                    "email" => $user["email"],
                    "email_prefix" => $emailPrefix,
                    "public_key" => $user["public_key"],
                    "private_key" => $user["private_key"],
                ];
                header("Location: registrasi.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Email atau password salah.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Email atau password salah.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter password" name="password" class="form-control" required>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
            <div class="mt-3">
                <a href="index.php">
                    <p>Belum punya akun? Daftar sekarang!</p>
                </a>
            </div>
        </form>
    </div>
</body>

</html>