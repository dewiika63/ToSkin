<?php
// Include file koneksi
include 'koneksi.php';

// Inisialisasi variabel untuk pesan kesalahan
$error_message = '';
$success_message = '';

// Periksa apakah form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $harga_jual = $_POST['harga_jual'];
    $total = $_POST['total'];
    $tanggal = $_POST['tanggal'];

    // Query untuk menambahkan data penjualan ke dalam tabel
    $query_penjualan = "INSERT INTO penjualan (id_barang, jumlah, harga_jual, total, tanggal) VALUES ('$id_barang', '$jumlah', '$harga_jual', '$total', '$tanggal')";

    // Eksekusi query penjualan
    $result_penjualan = mysqli_query($koneksi, $query_penjualan);

    // Periksa apakah query penjualan berhasil dieksekusi
    if ($result_penjualan) {
        // Jika berhasil, kurangi stok barang yang dibeli
        $query_stok = "UPDATE data_barang SET stok = stok - $jumlah WHERE id_barang = '$id_barang'";
        $result_stok = mysqli_query($koneksi, $query_stok);
        
        // Periksa apakah query stok berhasil dieksekusi
        if ($result_stok) {
            $success_message = "Data penjualan berhasil ditambahkan.";
        } else {
            // Jika gagal mengurangi stok, tampilkan pesan kesalahan
            $error_message = "Gagal mengurangi stok barang: " . mysqli_error($koneksi);
        }
    } else {
        // Jika gagal menambahkan data penjualan, tampilkan pesan kesalahan
        $error_message = "Gagal menambahkan data penjualan: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Penjualan Barang</h2>
        <?php if(isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>
        <?php if(isset($success_message)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="id_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Total</label>
                <input type="number" name="total" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Penjualan</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Penjualan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>