<?php  
require_once('izin.php');

mysqli_select_db($database_koneksi, $koneksi);
$query_barcode = "SELECT barcode.id_barcode FROM barcode LEFT JOIN produk ON kodeproduk = barcode ORDER BY id_barcode DESC";
$barcode = mysqli_query($query_barcode, $koneksi) or die(mysqli_error());

if (mysqli_num_rows($barcode) > 0) {
    while ($row = mysqli_fetch_assoc($barcode)) {
        $id = $row['id_barcode'];

        $deleteSQL = sprintf("DELETE FROM barcode WHERE id_barcode=%s",
                             GetSQLValueString($id, "int"));

        $Result1 = mysqli_query($deleteSQL, $koneksi) or die(errorQuery(mysqli_error()));

        $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                             GetSQLValueString($actual_link, "text"),
                             GetSQLValueString($ID, "int"));
        mysqli_query($activitySQL, $koneksi) or die(errorQuery(mysqli_error()));
    }

    pesanlink('Semua data berhasil dihapus', '?page=barcode/create');
} else {
    pesanlink('Tidak ada data untuk dihapus', '?page=barcode/create');
}
?>