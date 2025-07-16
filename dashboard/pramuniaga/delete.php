<?php  
$level = $_SESSION['MM_Level']; //8
restrict(2,$level);

if ((isset($_GET['id_kassa'])) && ($_GET['id_kassa'] != "")) {
  $deleteSQL = sprintf("DELETE FROM pramuniaga WHERE id_kassa=%s",
                       GetSQLValueString($_GET['id_kassa'], "int"));

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
  		pesanlink('Data berhasil dihapus','?page=pramuniaga/view');
  }
}
?>
