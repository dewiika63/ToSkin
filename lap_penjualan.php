<?php
// Include file koneksi
include 'koneksi.php';

// Query untuk mengambil data penjualan
$query = "SELECT penjualan.kode_penjualan, data_barang.nama_barang, penjualan.jumlah, penjualan.harga_jual, penjualan.total, penjualan.tanggal FROM penjualan INNER JOIN data_barang ON penjualan.id_barang = data_barang.id_barang";
$result = mysqli_query($koneksi, $query);

// Inisialisasi array untuk menyimpan data penjualan
$penjualan_data = [];

// Periksa apakah ada data penjualan
if(mysqli_num_rows($result) > 0) {
    // Jika ada, tambahkan data penjualan ke dalam array
    while($row = mysqli_fetch_assoc($result)) {
        $penjualan_data[] = $row;
    }
} else {
    // Jika tidak ada data penjualan, tampilkan pesan
    $empty_message = "Tidak ada data penjualan.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Laporan Penjualan</h2>
        <?php if(isset($empty_message)) { ?>
            <div class="alert alert-info" role="alert">
                <?php echo $empty_message; ?>
            </div>
        <?php } else { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Penjualan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga_Jual</th>
                        <th>Total</th>
                        <th>Tanggal Penjualan</th>
                        <th>Aksi</th> <!-- Tambahkan kolom untuk tombol cetak -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($penjualan_data as $penjualan) { ?>
                        <tr>
                            <td><?php echo $penjualan['kode_penjualan']; ?></td>
                            <td><?php echo $penjualan['nama_barang']; ?></td>
                            <td><?php echo $penjualan['jumlah']; ?></td>
                            <td><?php echo $penjualan['harga_jual']; ?></td>
                            <td><?php echo $penjualan['total']; ?></td>
                            <td><?php echo $penjualan['tanggal']; ?></td>
                            <td>
                                <form action="cetak_penjualan.php" method="post" target="_blank">
                                    <input type="hidden" name="kode_penjualan" value="<?php echo $penjualan['kode_penjualan']; ?>">
                                    <button type="submit" class="btn btn-primary">Cetak</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</body>
</html>