<?php
// Include koneksi.php terlebih dahulu untuk mendapatkan fungsi GetSQLValueString
if (file_exists('../../Connections/koneksi.php')) {
    require_once('../../Connections/koneksi.php');
} elseif (file_exists('../Connections/koneksi.php')) {
    require_once('../Connections/koneksi.php');
} elseif (file_exists('Connections/koneksi.php')) {
    require_once('Connections/koneksi.php');
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Penjualan = 10;
$pageNum_Penjualan = 0;
if (isset($_GET['pageNum_Penjualan'])) {
	$pageNum_Penjualan = $_GET['pageNum_Penjualan'];
}
$startRow_Penjualan = $pageNum_Penjualan * $maxRows_Penjualan;
$jenisbayar = 0;
$colname = 0;
$tgl1 = $tglsekarang;
$tgl2 = $tglsekarang;
$kat = 0;

// Query untuk filter kategori - versi ULTRA SEDERHANA
if(isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$kat = $_GET['kategori'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];

	// Query yang sangat sederhana - hanya ambil faktur yang memiliki produk kategori tertentu
	$query_Penjualan = sprintf(
		"SELECT DISTINCT f.idfaktur, f.tglfaktur, f.kodefaktur, f.addedfaktur, f.addbyfaktur, f.periode, f.datetimefaktur, f.kembalian, f.potongan, f.totalbayar, 
		(f.totalbayar - f.kembalian) AS totalbelanja, f.statusfaktur, f.qtyprint, f.printby, f.adminfaktur, f.namapelanggan 
		FROM faktur f 
		INNER JOIN transaksidetail td ON f.kodefaktur = td.faktur
		INNER JOIN produk p ON td.nama = p.namaproduk
		WHERE (f.tglfaktur BETWEEN %s AND %s) AND f.statusfaktur = 'Y' AND p.kategori = %s
		ORDER BY f.idfaktur DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($kat, "text")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	//total pendapatan - query sederhana
	$query_Pendapatan = sprintf(
		"SELECT SUM(f.totalbayar - f.kembalian) AS pendapatan 
		FROM faktur f 
		INNER JOIN transaksidetail td ON f.kodefaktur = td.faktur
		INNER JOIN produk p ON td.nama = p.namaproduk
		WHERE (f.tglfaktur BETWEEN %s AND %s) AND f.statusfaktur = 'Y' AND p.kategori = %s",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($kat, "text")
	);

	$query_Laba = sprintf(
		"SELECT SUM(((td.harga * td.qty) - (td.hargadasar * td.qty)) - td.diskon) AS laba
		FROM transaksidetail td
		INNER JOIN faktur f ON td.faktur = f.kodefaktur
		INNER JOIN produk p ON td.nama = p.namaproduk
		WHERE (f.tglfaktur BETWEEN %s AND %s) AND f.statusfaktur = 'Y' AND p.kategori = %s",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($kat, "text")
	);
} elseif (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
		GetSQLValueString($ta, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_Pendapatan = sprintf(
		"SELECT  SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
		GetSQLValueString($ta, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_Laba = sprintf(
		"SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) AS laba 
		FROM transaksidetail
		INNER JOIN faktur ON transaksidetail.faktur = faktur.kodefaktur
		WHERE tglfaktur BETWEEN %s AND %s",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
} else {
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s ORDER BY idfaktur DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_Pendapatan = sprintf(
		"SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s ORDER BY idfaktur DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	$query_Laba = sprintf(
		"SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) AS laba 
		FROM transaksidetail
		INNER JOIN faktur ON transaksidetail.faktur = faktur.kodefaktur
		WHERE tglfaktur BETWEEN %s AND %s",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);
}

$query_limit_Penjualan = sprintf("%s LIMIT %d, %d", $query_Penjualan, $startRow_Penjualan, $maxRows_Penjualan);

// Error handling yang sangat sederhana
$rs_Penjualan = mysqli_query($koneksi, $query_limit_Penjualan);
if (!$rs_Penjualan) {
    echo "<div style='background: #ffebee; color: #c62828; padding: 15px; margin: 15px; border: 1px solid #ef5350; border-radius: 5px;'>";
    echo "<h4><strong>⚠️ Error Query:</strong></h4>";
    echo "<p>" . mysqli_error($koneksi) . "</p>";
    echo "<p><strong>Query:</strong></p>";
    echo "<pre>" . htmlspecialchars($query_limit_Penjualan) . "</pre>";
    echo "</div>";
    $row_Penjualan = null;
} else {
    $row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);
}

$rs_total = mysqli_query($koneksi, $query_total);
if (!$rs_total) {
    echo "<div style='background: #fff3cd; color: #856404; padding: 10px; margin: 10px; border: 1px solid #ffeaa7; border-radius: 5px;'>";
    echo "<strong>Warning:</strong> Error query total: " . mysqli_error($koneksi);
    echo "</div>";
    $row_Total = array('jumlah' => 0);
} else {
    $row_Total = mysqli_fetch_assoc($rs_total);
}

$rs_pendapatan = mysqli_query($koneksi, $query_Pendapatan);
if (!$rs_pendapatan) {
    echo "<div style='background: #fff3cd; color: #856404; padding: 10px; margin: 10px; border: 1px solid #ffeaa7; border-radius: 5px;'>";
    echo "<strong>Warning:</strong> Error query pendapatan: " . mysqli_error($koneksi);
    echo "</div>";
    $row_Pendapatan = array('pendapatan' => 0);
} else {
    $row_Pendapatan = mysqli_fetch_assoc($rs_pendapatan);
}

$rs_laba = mysqli_query($koneksi, $query_Laba);
if (!$rs_laba) {
    echo "<div style='background: #fff3cd; color: #856404; padding: 10px; margin: 10px; border: 1px solid #ffeaa7; border-radius: 5px;'>";
    echo "<strong>Warning:</strong> Error query laba: " . mysqli_error($koneksi);
    echo "</div>";
    $row_Laba = array('laba' => 0);
} else {
    $row_Laba = mysqli_fetch_assoc($rs_laba);
}

//kasir
$query_Kasir = sprintf(
	"SELECT DISTINCT(`addbyfaktur`) as id, vw_login.Nama FROM faktur
		LEFT JOIN vw_login ON addbyfaktur = ID
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($ta, "text")
);
$Kassa = mysqli_query($koneksi, $query_Kasir) or die(errorQuery(mysqli_error($koneksi)));
$row_Kassa = mysqli_fetch_assoc($Kassa);
$totalRows_Kassa = mysqli_num_rows($Kassa);

//kasir
$query_Faktur = sprintf(
	"SELECT DISTINCT(`jenisbayar`) as jenisbayar FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($ta, "text")
);
$Faktur = mysqli_query($koneksi, $query_Faktur) or die(errorQuery(mysqli_error($koneksi)));
$row_Faktur = mysqli_fetch_assoc($Faktur);
$totalRows_Faktur = mysqli_num_rows($Faktur);

//Kategori
$query_kategori = sprintf(
	"SELECT * FROM kategori ORDER BY namakategori ASC"
);
$kategori = mysqli_query($koneksi, $query_kategori) or die(errorQuery(mysqli_error($koneksi)));
$row_kategori = mysqli_fetch_assoc($kategori);

if (isset($_GET['totalRows_Penjualan'])) {
	$totalRows_Penjualan = $_GET['totalRows_Penjualan'];
} else {
	$all_Penjualan = mysqli_query($koneksi, $query_Penjualan);
	$totalRows_Penjualan = mysqli_num_rows($all_Penjualan);
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
?> 