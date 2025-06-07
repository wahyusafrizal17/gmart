<?php  
if ((isset($_GET['faktur'])) && ($_GET['faktur'] != "") && (isset($_GET['sandi']))) {
  $deleteSQL = sprintf("DELETE FROM faktur WHERE kodefaktur=%s AND statusfaktur = %s",
                       GetSQLValueString($_GET['sandi'], "int"),
					   GetSQLValueString('N', "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(mysql_error());
  
  $deleteSQL2 = sprintf("DELETE FROM transaksitemp WHERE faktur=%s",
                       GetSQLValueString($_GET['faktur'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result2 = mysql_query($deleteSQL2, $koneksi) or die(mysql_error());

  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($actual_link, "text"),
                       GetSQLValueString($ID, "int"));
	mysql_select_db($database_koneksi, $koneksi);
  $ResultSQL = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));	
  //26 desember close

  if ($Result2){
  		pesanlink('Faktur berhasil dihapus beserta item','?page=tabulasi/penjualan');
  }
}

if ((isset($_GET['fakturx'])) && ($_GET['fakturx'] != "")) {
  $deleteSQL = sprintf("DELETE FROM faktur WHERE kodefaktur=%s AND statusfaktur = %s",
                       GetSQLValueString($_GET['fakturx'], "int"),
					   GetSQLValueString('Y', "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(mysql_error());
  
  $deleteSQL2 = sprintf("DELETE FROM transaksidetail WHERE faktur=%s",
                       GetSQLValueString($_GET['fakturx'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result2 = mysql_query($deleteSQL2, $koneksi) or die(mysql_error());

 //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($actual_link, "text"),
                       GetSQLValueString($ID, "int"));
	mysql_select_db($database_koneksi, $koneksi);
  $ResultSQL = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));	
  //26 desember close

  if ($Result2){
  		pesanlink('Faktur berhasil dihapus beserta item','?page=tabulasi/penjualan');
  }
}
?>
