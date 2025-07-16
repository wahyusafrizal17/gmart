<?php  
if ((isset($_GET['faktur'])) && ($_GET['faktur'] != "") && (isset($_GET['sandi']))) {
  $deleteSQL = sprintf("DELETE FROM faktur WHERE kodefaktur=%s AND statusfaktur = %s",
                       GetSQLValueString($koneksi, $_GET['sandi'], "int"),
					   GetSQLValueString($koneksi, 'N', "text"));

  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(mysqli_error());
  
  $deleteSQL2 = sprintf("DELETE FROM transaksitemp WHERE faktur=%s",
                       GetSQLValueString($koneksi, $_GET['faktur'], "text"));

  //mysqli_select_db($database_koneksi);
  $Result2 = mysqli_query($koneksi, $deleteSQL2) or die(mysqli_error());

  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($koneksi, $actual_link, "text"),
                       GetSQLValueString($koneksi, $ID, "int"));
	//mysqli_select_db($database_koneksi);
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error()));	
  //26 desember close

  if ($Result2){
  		pesanlink('Faktur berhasil dihapus beserta item','?page=tabulasi/penjualan');
  }
}

if ((isset($_GET['fakturx'])) && ($_GET['fakturx'] != "")) {
  $deleteSQL = sprintf("DELETE FROM faktur WHERE kodefaktur=%s AND statusfaktur = %s",
                       GetSQLValueString($koneksi, $_GET['fakturx'], "int"),
					   GetSQLValueString($koneksi, 'Y', "text"));

  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(mysqli_error());
  
  $deleteSQL2 = sprintf("DELETE FROM transaksidetail WHERE faktur=%s",
                       GetSQLValueString($koneksi, $_GET['fakturx'], "text"));

  //mysqli_select_db($database_koneksi);
  $Result2 = mysqli_query($koneksi, $deleteSQL2) or die(mysqli_error());

 //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($koneksi, $actual_link, "text"),
                       GetSQLValueString($koneksi, $ID, "int"));
	//mysqli_select_db($database_koneksi);
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error()));	
  //26 desember close

  if ($Result2){
  		pesanlink('Faktur berhasil dihapus beserta item','?page=tabulasi/penjualan');
  }
}
?>
