<?php
session_start();

// Redirect ke login.php jika user belum login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari session
$user = $_SESSION["user"];
$publicKey = htmlspecialchars($user["public_key"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Selamat Datang !, <h3><?php echo htmlspecialchars($user["name"]); ?></h3></h1>
        <a href="keluar.php" class="btn btn-danger mt-3">LogOut</a>
    </div>
</body>

</html>
