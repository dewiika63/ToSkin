<?php
// Include file koneksi
include 'koneksi.php';

// Inisialisasi variabel untuk pesan kesalahan
$error_message = '';
$success_message = '';

// Periksa apakah form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];
    $total = $_POST['total'];
    $tanggal = $_POST['tanggal'];

    // Periksa apakah ID barang terdaftar dalam database
    $query_check_barang = "SELECT * FROM data_barang WHERE nama_barang = '$nama_barang'";
    $result_check_barang = mysqli_query($koneksi, $query_check_barang);

    if (mysqli_num_rows($result_check_barang) > 0) {
        // Jika ID barang terdaftar, lanjutkan dengan transaksi pembelian
        $row = mysqli_fetch_assoc($result_check_barang);
        $id_barang = $row['id_barang'];

        // Mulai transaksi
        mysqli_begin_transaction($koneksi);

        // Query untuk menambahkan data pembelian ke dalam tabel
        $query_pembelian = "INSERT INTO pembelian (id_barang, jumlah, harga_beli, total, tanggal) VALUES ('$id_barang', '$jumlah', '$harga_beli', '$total', '$tanggal')";

        // Eksekusi query pembelian
        $result_pembelian = mysqli_query($koneksi, $query_pembelian);

        // Query untuk mengupdate stok barang
        $query_update_stok = "UPDATE data_barang SET stok = stok + '$jumlah' WHERE id_barang = '$id_barang'";

        // Eksekusi query update stok barang
        $result_update_stok = mysqli_query($koneksi, $query_update_stok);

        // Periksa apakah query pembelian dan update stok berhasil dieksekusi
        if ($result_pembelian && $result_update_stok) {
            // Commit transaksi jika semua query berhasil dieksekusi
            mysqli_commit($koneksi);
            $success_message = "Transaksi pembelian berhasil. Stok barang berhasil diperbarui.";
        } else {
            // Rollback transaksi jika terjadi kesalahan pada salah satu query
            mysqli_rollback($koneksi);
            $error_message = "Gagal melakukan transaksi pembelian: " . mysqli_error($koneksi);
        }
    } else {
        // Jika ID barang tidak ditemukan dalam database
        $error_message = "Nama barang tidak terdaftar dalam database. Pembelian gagal.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Pembelian Barang</h2>
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
                <input type="text" name="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Beli</label>
                <input type="text" name="harga_beli" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Total</label>
                <input type="number" name="total" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Pembelian</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Pembelian</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>