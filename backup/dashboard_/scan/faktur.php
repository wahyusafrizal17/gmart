<?php 
if ($faktur == NULL){
		$insertSQL = sprintf("INSERT INTO faktur (tglfaktur, statusfaktur, kodefaktur, addedfaktur, addbyfaktur, adminfaktur, periode) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($today, "date"),
						   GetSQLValueString('N', "text"),
						   GetSQLValueString($kodeacak, "text"),
						   GetSQLValueString(time(), "int"),
						   GetSQLValueString($ID, "int"),
						   GetSQLValueString($nama, "text"),
						   GetSQLValueString($ta, "text"));
	
	  mysql_select_db($database_koneksi, $koneksi);
	  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
	 
	
	mysql_select_db($database_koneksi, $koneksi);
	$query_Faktur = sprintf("SELECT * FROM faktur WHERE tglfaktur = %s AND addbyfaktur = %s AND periode = %s AND statusfaktur = %s ORDER BY idfaktur DESC", 
						   GetSQLValueString($tglsekarang, "date"),
						   GetSQLValueString($ID, "int"),
						   GetSQLValueString($ta, "text"),					   
						   GetSQLValueString('N', "text"));
	$Faktur = mysql_query($query_Faktur, $koneksi) or die(mysql_error());
	$row_Faktur = mysql_fetch_assoc($Faktur);
	$totalRows_Faktur = mysql_num_rows($Faktur);
	//MEMBUAT NILAI FAKTUR
	$faktur = $row_Faktur['kodefaktur'];
    
}
