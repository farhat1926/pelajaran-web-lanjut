<?php

session_start();
if (isset($_SESSION["user"])) {
    header("Location: registrasi.php");
    exit;
}

// Import library phpseclib dan helper RSA
require_once "vendor/autoload.php";

use phpseclib3\Crypt\RSA;

// Fungsi untuk membuat pasangan kunci RSA
function generateRSAKeyPair() {
    $rsa = RSA::createKey(2048); // Membuat kunci RSA 2048-bit
    return [
        'private_key' => $rsa->toString('PKCS1'),
        'public_key' => $rsa->getPublicKey()->toString('PKCS1'),
    ];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Sanitasi input
            $fullName = htmlspecialchars(trim($_POST["fullname"] ?? ''));
            $email = htmlspecialchars(trim($_POST["email"] ?? ''));
            $password = $_POST["password"] ?? '';
            $passwordRepeat = $_POST["repeat_password"] ?? '';

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            // Validasi input
            if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                array_push($errors, "All fields are required.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid.");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters.");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Passwords do not match.");
            }

            require_once "database.php";

            // Pencegahan SQL Injection
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $errors[] = "Email already exists.";
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>" . htmlspecialchars($error) . "</div>";
                }
            } else {
                // Generate RSA Key Pair
                $keys = generateRSAKeyPair();
                $privateKey = $keys['private_key'];
                $publicKey = $keys['public_key'];

                // Simpan data ke database
                $sql = "INSERT INTO users(full_name, email, password, public_key, private_key) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $passwordHash, $publicKey, $privateKey);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<div class='alert alert-success'>You are registered successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
                }
            }
        }
        ?>

        <form action="index.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
            <div class="mt-3">
                <a href="login.php">
                    <p>Udah punya akun? Langsung login gassin!</p>
                </a>
            </div>
        </form>
    </div>

</body>

</html>


