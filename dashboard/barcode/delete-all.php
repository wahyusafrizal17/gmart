<?php  
require_once('izin.php');

mysqli_select_db($koneksi, $database_koneksi);
$query_barcode = "SELECT barcode.id_barcode FROM barcode LEFT JOIN produk ON kodeproduk = barcode ORDER BY id_barcode DESC";
$barcode = mysqli_query($koneksi, $query_barcode) or die(mysqli_error($koneksi));

if (mysqli_num_rows($barcode) > 0) {
    while ($row = mysqli_fetch_assoc($barcode)) {
        $id = $row['id_barcode'];

        $deleteSQL = sprintf("DELETE FROM barcode WHERE id_barcode=%s",
                             GetSQLValueString($id, "int"));

        $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error($koneksi)));

        $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                             GetSQLValueString($actual_link, "text"),
                             GetSQLValueString($ID, "int"));
        mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi)));
    }

    pesanlink('Semua data berhasil dihapus', '?page=barcode/create');
} else {
    pesanlink('Tidak ada data untuk dihapus', '?page=barcode/create');
}
?>