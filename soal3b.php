<?php
// Koneksi ke database
$mysqli = new mysqli("localhost", "root", "", "testdb");

// Cek koneksi
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Ambil parameter pencarian dari form
$search_nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$search_alamat = isset($_GET['alamat']) ? $_GET['alamat'] : '';
$search_hobi = isset($_GET['hobi']) ? $_GET['hobi'] : '';

// Pagination setup
$limit = 12; // Limit per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$count_sql = "SELECT COUNT(DISTINCT p.id) AS total 
              FROM person p 
              LEFT JOIN hobi h ON p.id = h.person_id 
              WHERE p.nama LIKE '%$search_nama%' 
              AND p.alamat LIKE '%$search_alamat%'
              AND h.hobi LIKE '%$search_hobi%'";

$count_result = $mysqli->query($count_sql);
$total_data = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Query untuk mencari data berdasarkan input form dengan limit untuk pagination
$sql = "SELECT p.nama, p.alamat, GROUP_CONCAT(h.hobi SEPARATOR ', ') AS hobi 
        FROM person p 
        LEFT JOIN hobi h ON p.id = h.person_id 
        WHERE p.nama LIKE '%$search_nama%' 
        AND p.alamat LIKE '%$search_alamat%'
        AND h.hobi LIKE '%$search_hobi%'
        GROUP BY p.id
        LIMIT $limit OFFSET $offset";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Person dan Hobi</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .form-container {
            width: 50%;
            margin: 20px auto;
            border: 1px solid black;
            padding: 10px;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid black;
            color: black;
        }
        .pagination a.active {
            background-color: black;
            color: white;
        }
        .form-group {
            display: flex;
            margin-bottom: 10px;
        }
        .form-group label {
            flex: 2;
        }
        .form-group input {

            width: 800px;
        }

        .form-btn input {
        width: 150px;
            }
    </style>
</head>
<body>

<div class="form-container">
<form action="soal3b.php" method="get">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo $search_nama; ?>">
        </div>
        <div class="form-group">
            <label>Alamat:</label>
            <input type="text" name="alamat" value="<?php echo $search_alamat; ?>">
        </div>
        <div class="form-group">
            <label>Hobi:</label>
            <input type="text" name="hobi" value="<?php echo $search_hobi; ?>">
        </div>
        <div class="form-btn">
            <input type="submit" value="SEARCH">
        </div>
    </form>
</div>

<table>
    <tr>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Hobi</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['hobi']; ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">Tidak ada hasil pencarian</td>
        </tr>
    <?php endif; ?>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($total_pages > 1): ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?nama=<?php echo $search_nama; ?>&alamat=<?php echo $search_alamat; ?>&hobi=<?php echo $search_hobi; ?>&page=<?php echo $i; ?>" 
               class="<?php echo ($i == $page) ? 'active' : ''; ?>">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    <?php endif; ?>
</div>

</body>
</html>

