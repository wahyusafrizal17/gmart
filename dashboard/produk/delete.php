<?php  
require_once('izin.php');
if ((isset($_GET['id_produk'])) && ($_GET['id_produk'] != "")) {
  $deleteSQL = sprintf("DELETE FROM produk WHERE idproduk=%s",
                       GetSQLValueString($_GET['id_produk'], "int"));

//  mysqli_select_db($database_koneksi, $koneksi);
  $Result1 = mysqli_query($deleteSQL, $koneksi) or die(errorQuery(mysqli_error()));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($actual_link, "text"),
                       GetSQLValueString($ID, "int"));
	mysqli_select_db($database_koneksi, $koneksi);
  $ResultSQL = mysqli_query($activitySQL, $koneksi) or die(errorQuery(mysqli_error()));	
  //26 desember close

  if ($Result1) {
  		pesanlink('Data berhasil dihapus','?page=produk/view');
  }
}
?>
