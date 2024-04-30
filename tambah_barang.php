<?php
// Include file koneksi
include 'koneksi.php';

// Periksa apakah form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form tambah
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    // Query untuk menambahkan data baru ke dalam tabel
    $query = "INSERT INTO data_barang (nama_barang, stok, harga_beli, harga_jual) VALUES ('$nama_barang', '$stok', '$harga_beli', '$harga_jual')";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Jika berhasil, kembalikan ke halaman data_barang.php
        header("Location: data_barang.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        $error_message = "Gagal menambahkan data barang: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Barang</h2>
        <?php if(isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Beli</label>
                <input type="text" name="harga_beli" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Barang</button>
            <a href="data_barang.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>