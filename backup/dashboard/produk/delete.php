<?php
require_once('izin.php');
if ($level <= 2) {
  if ((isset($_GET['id_produk'])) && ($_GET['id_produk'] != "")) {
    $deleteSQL = sprintf(
      "DELETE FROM produk WHERE idproduk=%s",
      GetSQLValueString($koneksi, $_GET['id_produk'], "int")
    );

    //  //mysqli_select_db($database_koneksi);
    $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error($koneksi)));

    //26 Desember open
    $activitySQL = sprintf(
      "INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
      GetSQLValueString($koneksi, $actual_link, "text"),
      GetSQLValueString($koneksi, $ID, "int")
    );
    //mysqli_select_db($database_koneksi);
    $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi)));
    //26 desember close

    if ($Result1) {
      pesanlink('Data berhasil dihapus', '?page=produk/view');
    }
  }
}
