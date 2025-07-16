<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Penjualan = 10;
$pageNum_Penjualan = 0;
if (isset($_GET['pageNum_Penjualan'])) {
	$pageNum_Penjualan = $_GET['pageNum_Penjualan'];
}
$startRow_Penjualan = $pageNum_Penjualan * $maxRows_Penjualan;

$colname = "-1";
$tgl1 = "-1";
$tgl2 = "-1";
if (isset($_GET['cari'])) {
	$colname = $_GET['cari'];
	//mysql_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT kodefaktur, SUM(qty) as JumlahItem, SUM(harga * qty) as totalbelanja, tglfaktur, addby, statusfaktur, vw_login.Nama FROM `faktur` 
		LEFT JOIN transaksitemp ON faktur = kodefaktur
		LEFT JOIN vw_login ON addby = vw_login.ID 
		WHERE kodefaktur = %s AND transaksitemp.periode = %s AND tanggal = CURDATE() GROUP BY kodefaktur ORDER BY kodefaktur DESC",
		GetSQLValueString($colname, "text"),
		GetSQLValueString($ta, "text")
	);
} elseif (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysql_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT kodefaktur, SUM(qty) as JumlahItem, SUM(harga * qty) as totalbelanja, tglfaktur, addby, statusfaktur, vw_login.Nama FROM `faktur` 
		LEFT JOIN transaksitemp ON faktur = kodefaktur
		LEFT JOIN vw_login ON addby = vw_login.ID 
		WHERE transaksitemp.periode = %s AND tglfaktur BETWEEN %s AND %s GROUP BY kodefaktur ORDER BY kodefaktur DESC",
		GetSQLValueString($ta, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
} else {
	//mysql_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT kodefaktur, SUM(qty) as JumlahItem, SUM(harga * qty) as totalbelanja, tglfaktur, addby, statusfaktur, vw_login.Nama FROM `faktur` 
		LEFT JOIN transaksitemp ON faktur = kodefaktur 
		LEFT JOIN vw_login ON addby = vw_login.ID 
		WHERE transaksitemp.periode = %s AND tglfaktur = CURDATE() GROUP BY kodefaktur ORDER BY kodefaktur DESC",
		GetSQLValueString($ta, "text")
	);
}
$query_limit_Penjualan = sprintf("%s LIMIT %d, %d", $query_Penjualan, $startRow_Penjualan, $maxRows_Penjualan);
$rs_Penjualan = mysql_query($query_limit_Penjualan, $koneksi) or die(mysql_error());
$row_Penjualan = mysql_fetch_assoc($rs_Penjualan);

if (isset($_GET['totalRows_Penjualan'])) {
	$totalRows_Penjualan = $_GET['totalRows_Penjualan'];
} else {
	$all_Penjualan = mysql_query($query_Penjualan, $koneksi);
	$totalRows_Penjualan = mysql_num_rows($all_Penjualan);
}
$totalPages_Penjualan = ceil($totalRows_Penjualan / $maxRows_Penjualan) - 1;

$queryString_Penjualan = "";
if (!empty($_SERVER['QUERY_STRING'])) {
	$params = explode("&", $_SERVER['QUERY_STRING']);
	$newParams = array();
	foreach ($params as $param) {
		if (
			stristr($param, "pageNum_Penjualan") == false &&
			stristr($param, "totalRows_Penjualan") == false
		) {
			array_push($newParams, $param);
		}
	}
	if (count($newParams) != 0) {
		$queryString_Penjualan = "&" . htmlentities(implode("&", $newParams));
	}
}
$queryString_Penjualan = sprintf("&totalRows_Penjualan=%d%s", $totalRows_Penjualan, $queryString_Penjualan);
