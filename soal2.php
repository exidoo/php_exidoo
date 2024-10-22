<?php
// Mulai sesi di bagian paling atas
session_start();

// Aktifkan pelaporan error untuk menangkap kesalahan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Jika ada pengiriman form (submit), naikkan step
if (isset($_POST['submit'])) {
    if (isset($_SESSION['step'])) {
        $_SESSION['step']++;
    } else {
        $_SESSION['step'] = 1;
    }

    // Simpan data dari setiap step ke dalam session
    if (isset($_POST['nama'])) {
        $_SESSION['nama'] = $_POST['nama'];
    }
    if (isset($_POST['umur'])) {
        $_SESSION['umur'] = $_POST['umur'];
    }
    if (isset($_POST['hobi'])) {
        $_SESSION['hobi'] = $_POST['hobi'];
    }
} else {
    // Reset ke langkah pertama saat halaman di-refresh (jika tidak ada submit)
    $_SESSION['step'] = 1;
}

$step = $_SESSION['step'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            border: 2px solid black;
            padding: 20px;
            width: 350px;
            margin: 20px auto;
            text-align: center;
        }
        input[type="text"] {
            width: 200px;
            padding: 5px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px;
        }
        .display-flex{
            display:flex;
            justify-content: center;
            align-items:center;
            gap:1rem;
        }
        .text-start{
            text-align: left;
        }
    </style>
</head>
<body>

<div class="form-container">
    <?php if ($step == 1): ?>
        <!-- Form untuk langkah pertama (Nama) -->
        <form action="" method="post" >
           <div class="display-flex">
               <label for="nama">Nama Anda:</label>
               <input type="text" id="nama" name="nama" required>
           </div>
            <br><br>
            <input type="submit" name="submit" value="SUBMIT">
        </form>

    <?php elseif ($step == 2): ?>
        <!-- Form untuk langkah kedua (Umur) -->
        <form action="" method="post">
            <div class="display-flex">
                <label for="umur">Umur Anda:</label>
                <input type="text" id="umur" name="umur" required>
            </div>
            <br><br>
            <input type="submit" name="submit" value="SUBMIT">
        </form>

    <?php elseif ($step == 3): ?>
        <!-- Form untuk langkah ketiga (Hobi) -->
        <form action="" method="post">
            <div class="display-flex">
                <label for="hobi">Hobi Anda:</label>
                <input type="text" id="hobi" name="hobi" required>
            </div>
            <br><br>
            <input type="submit" name="submit" value="SUBMIT">
        </form>

    <?php elseif ($step == 4): ?>
        <!-- Tampilan ringkasan input (Nama, Umur, Hobi) -->
        <div class="text-start">
            <p>Nama: <?php echo htmlspecialchars($_SESSION['nama']); ?></p>
            <p>Umur: <?php echo htmlspecialchars($_SESSION['umur']); ?></p>
            <p>Hobi: <?php echo htmlspecialchars($_SESSION['hobi']); ?></p>
        </div>

    <?php endif; ?>
</div>

</body>
</html>
