<?php
// Include file koneksi
include 'koneksi.php';

// Periksa apakah parameter id_barang telah diterima
if(isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];

    // Query untuk mengambil data barang berdasarkan id_barang
    $query = "SELECT * FROM data_barang WHERE id_barang = $id_barang";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah data barang ditemukan
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $nama_barang = $row['nama_barang'];
        // $stok = $row['stok'];
        $harga_beli = $row['harga_beli'];
        $harga_jual = $row['harga_jual'];
    } else {
        echo "Data barang tidak ditemukan.";
        exit();
    }
} else {
    echo "Parameter id_barang tidak diterima.";
    exit();
}

// Periksa apakah form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form edit
    $nama_barang = $_POST['nama_barang'];
    // $stok = $_POST['stok'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    // Query untuk memperbarui data barang
    $query = "UPDATE data_barang SET nama_barang = '$nama_barang', harga_beli = '$harga_beli', harga_jual = '$harga_jual' WHERE id_barang = $id_barang";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Jika berhasil, kembalikan ke halaman data_barang.php
        header("Location: data_barang.php");
        exit();
    } else {
        echo "Gagal memperbarui data barang: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Barang</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_barang=' . $id_barang; ?>" method="post">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="<?php echo $nama_barang; ?>" required>
            </div>
            <!-- <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" value="<?php echo $stok; ?>" required>
            </div> -->
            <div class="form-group">
                <label>Harga Beli</label>
                <input type="text" name="harga_beli" class="form-control" value="<?php echo $harga_beli; ?>" required>
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual" class="form-control" value="<?php echo $harga_jual; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="data_barang.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>