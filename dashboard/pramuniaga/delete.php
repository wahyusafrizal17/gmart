<?php  
$level = $_SESSION['MM_Level']; //8
restrict(2,$level);

if ((isset($_GET['id_kassa'])) && ($_GET['id_kassa'] != "")) {
  $deleteSQL = sprintf("DELETE FROM pramuniaga WHERE id_kassa=%s",
                       GetSQLValueString($_GET['id_kassa'], "int"));

//  mysqli_select_db($database_koneksi, $koneksi);
  mysqli_select_db($koneksi, $database_koneksi);
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error($koneksi)));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($actual_link, "text"),
                       GetSQLValueString($ID, "int"));
	mysqli_select_db($koneksi, $database_koneksi);
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi))); 
  //26 desember close

  if ($Result1) {
  		pesanlink('Data berhasil dihapus','?page=pramuniaga/view');
  }
}
?>
