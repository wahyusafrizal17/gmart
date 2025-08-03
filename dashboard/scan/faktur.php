<?php 
// Initialize variables if not set
if (!isset($ID) || empty($ID)) {
	$ID = 2; // Default admin ID
	$nama = 'GHALIH'; // Default admin name
}
if (!isset($ta) || empty($ta)) {
	$ta = '2024'; // Default periode
}
if (!isset($today) || empty($today)) {
	$today = date('Y-m-d');
}
if (!isset($tglsekarang) || empty($tglsekarang)) {
	$tglsekarang = date('Y-m-d');
}

// Initialize faktur variable
$faktur = null;

// Check if faktur exists for today
$query_Faktur = sprintf("SELECT * FROM faktur WHERE tglfaktur = %s AND addbyfaktur = %s AND periode = %s AND statusfaktur = %s ORDER BY idfaktur DESC", 
	GetSQLValueString($tglsekarang, "date"),
	GetSQLValueString($ID, "int"),
	GetSQLValueString($ta, "text"),
	GetSQLValueString('N', "text"));
$Faktur = mysqli_query($koneksi, $query_Faktur) or die(mysqli_error($koneksi));
$row_Faktur = mysqli_fetch_assoc($Faktur);
$totalRows_Faktur = mysqli_num_rows($Faktur);

// If no faktur exists, create new one
if ($totalRows_Faktur == 0) {
	$kodeacak = time(); // Generate unique faktur code
	
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
	
	if ($Result1) {
		$faktur = $kodeacak;
	} else {
		$faktur = null;
	}
} else {
	// Use existing faktur
	$faktur = $row_Faktur['kodefaktur'];
}

// If faktur is still null, set a default
if (empty($faktur)) {
	$faktur = time(); // Fallback to timestamp
}
?>
