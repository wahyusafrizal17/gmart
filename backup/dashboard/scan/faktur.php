<?php 
if ($faktur == NULL){
		$insertSQL = sprintf("INSERT INTO faktur (tglfaktur, statusfaktur, kodefaktur, addedfaktur, addbyfaktur, adminfaktur, periode) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($koneksi, $today, "date"),
						   GetSQLValueString($koneksi, 'N', "text"),
						   GetSQLValueString($koneksi, $kodeacak, "text"),
						   GetSQLValueString($koneksi, time(), "int"),
						   GetSQLValueString($koneksi, $ID, "int"),
						   GetSQLValueString($koneksi, $nama, "text"),
						   GetSQLValueString($koneksi, $ta, "text"));
	
	  //mysqli_select_db($database_koneksi);
	  $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());
	 
	
	//mysqli_select_db($database_koneksi);
	$query_Faktur = sprintf("SELECT * FROM faktur WHERE tglfaktur = %s AND addbyfaktur = %s AND periode = %s AND statusfaktur = %s ORDER BY idfaktur DESC", 
						   GetSQLValueString($koneksi, $tglsekarang, "date"),
						   GetSQLValueString($koneksi, $ID, "int"),
						   GetSQLValueString($koneksi, $ta, "text"),					   
						   GetSQLValueString($koneksi, 'N', "text"));
	$Faktur = mysqli_query($koneksi, $query_Faktur) or die(mysqli_error());
	$row_Faktur = mysqli_fetch_assoc($Faktur);
	$totalRows_Faktur = mysqli_num_rows($Faktur);
	//MEMBUAT NILAI FAKTUR
	$faktur = $row_Faktur['kodefaktur'];
    
}
