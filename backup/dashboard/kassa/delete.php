<?php  
require_once('izin.php');
if ((isset($_GET['id_kassa'])) && ($_GET['id_kassa'] != "")) {
  $deleteSQL = sprintf("DELETE FROM kassa WHERE id_kassa=%s",
                       GetSQLValueString($koneksi, $_GET['id_kassa'], "int"));

//  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error()));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($koneksi, $actual_link, "text"),
                       GetSQLValueString($koneksi, $ID, "int"));
	//mysqli_select_db($database_koneksi);
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error()));	
  //26 desember close

  if ($Result1) {
  		pesanlink('Data berhasil dihapus','?page=kassa/view');
  }
}
?>
