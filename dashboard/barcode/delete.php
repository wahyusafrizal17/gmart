<?php  
require_once('izin.php');

if ((isset($_GET['id_barcode'])) && ($_GET['id_barcode'] != "")) {
  $deleteSQL = sprintf("DELETE FROM barcode WHERE id_barcode=%s",
                       GetSQLValueString($_GET['id_barcode'], "int"));

//  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(errorQuery(mysql_error()));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($actual_link, "text"),
                       GetSQLValueString($ID, "int"));
	mysql_select_db($database_koneksi, $koneksi);
  $ResultSQL = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));	
  //26 desember close

  if ($Result1) {
  		pesanlink('Data berhasil dihapus','?page=barcode/create');
  }
}
?>
