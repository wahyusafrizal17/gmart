<?php 
if ($faktur == NULL){
	$insertSQL = sprintf("INSERT INTO faktur (tglfaktur, statusfaktur, kodefaktur, addedfaktur, addbyfaktur, adminfaktur, periode, qtyprint, printby) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($today, "date"),
		GetSQLValueString('N', "text"),
		GetSQLValueString($kodeacak, "text"),
		GetSQLValueString(time(), "int"),
		GetSQLValueString($ID, "int"),
		GetSQLValueString($nama, "text"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString(0, "int"), // qtyprint default 0
		'NULL' // printby default NULL
	);

	$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));

	$query_Faktur = sprintf("SELECT * FROM faktur WHERE tglfaktur = %s AND addbyfaktur = %s AND periode = %s AND statusfaktur = %s ORDER BY idfaktur DESC", 
		GetSQLValueString($tglsekarang, "date"),
		GetSQLValueString($ID, "int"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString('N', "text"));
	$Faktur = mysqli_query($koneksi, $query_Faktur) or die(mysqli_error($koneksi));
	$row_Faktur = mysqli_fetch_assoc($Faktur);
	$totalRows_Faktur = mysqli_num_rows($Faktur);
	//MEMBUAT NILAI FAKTUR
	$faktur = $row_Faktur['kodefaktur'];
    
}
