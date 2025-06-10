<?php
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

if (isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kategori']) && ($_GET['kategori'] != 0)) {
	$jenisbayar = $_GET['jenisbayar'];
	if ($jenisbayar == "0") {
		$colname = $_GET['kasir'];
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
		$kat = $_GET['kategori'];
		//mysql_select_db($database_koneksi, $koneksi);
		$query_Penjualan = sprintf(
			"SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS totalbelanja, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.addbyfaktur = %s AND  a.periode = %s AND a.kodefaktur=b.faktur AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($colname, "text"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);

		$query_total = sprintf(
			"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date")
		);

		//total pendapatan
		$query_Pendapatan = sprintf(
			"SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS pendapatan, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur=%s AND  a.periode = %s AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($colname, "text"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);
	} else {
		$colname = $_GET['kasir'];
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
		$kat = $_GET['kategori'];
		$jenisbayar = $_GET['jenisbayar'];
		//mysql_select_db($database_koneksi, $koneksi);
		$query_Penjualan = sprintf(
			"SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS totalbelanja, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE a.jenisbayar= %s  AND  a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND a.kodefaktur=b.faktur AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
			GetSQLValueString($jenisbayar, "text"),
			GetSQLValueString($colname, "text"),
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date"),
			GetSQLValueString($ta, "text"),
			GetSQLValueString($kat, 'text')
		);

		$query_total = sprintf(
			"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
			GetSQLValueString($tgl1, "date"),
			GetSQLValueString($tgl2, "date")
		);

		//total pendapatan
		$query_Pendapatan =
			sprintf(
				"SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS pendapatan, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE a.jenisbayar=%s AND a.addbyfaktur=%s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y'  AND  a.periode = %s AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
				GetSQLValueString($jenisbayar, "text"),
				GetSQLValueString($colname, "text"),
				GetSQLValueString($tgl1, "date"),
				GetSQLValueString($tgl2, "date"),
				GetSQLValueString($ta, "text"),
				GetSQLValueString($kat, 'text')
			);
	}

	//echo "<script>alert('ini tanggal kasir jenis bayar');</script>";
} elseif (isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$colname = $_GET['kasir'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysql_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf(
		"SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
		GetSQLValueString($colname, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	//total pendapatan
	$query_Pendapatan = sprintf(
		"SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s ORDER BY idfaktur DESC",
		GetSQLValueString($colname, "text"),
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text")
	);
	//echo "<script>alert('ini tanggal kasir');</script>";
} elseif(isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$kat = $_GET['kategori'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysql_select_db($database_koneksi, $koneksi);

	$query_Penjualan = sprintf(
		"SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS totalbelanja, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND a.kodefaktur=b.faktur AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);

	$query_total = sprintf(
		"SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date")
	);

	//total pendapatan
	$query_Pendapatan = sprintf(
		"SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS pendapatan, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
		GetSQLValueString($tgl1, "date"),
		GetSQLValueString($tgl2, "date"),
		GetSQLValueString($ta, "text"),
		GetSQLValueString($kat, "text")
	);
} elseif (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	//mysql_select_db($database_koneksi, $koneksi);
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
	//echo "<script>alert('ini tanggal');</script>";
	//total pendapatan
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
	//mysql_select_db($database_koneksi, $koneksi);
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
$rs_Penjualan = mysql_query($query_limit_Penjualan, $koneksi) or die(mysql_error());
$row_Penjualan = mysql_fetch_assoc($rs_Penjualan);

$rs_total = mysql_query($query_total, $koneksi) or die(mysql_error());
$row_Total = mysql_fetch_assoc($rs_total);

$rs_pendapatan = mysql_query($query_Pendapatan, $koneksi) or die(mysql_error());
$row_Pendapatan = mysql_fetch_assoc($rs_pendapatan);

$rs_laba = mysql_query($query_Laba, $koneksi) or die(mysql_error());
$row_Laba = mysql_fetch_assoc($rs_laba);

//kasir
$query_Kasir = sprintf(
	"SELECT DISTINCT(`addbyfaktur`) as id, vw_login.Nama FROM faktur
		LEFT JOIN vw_login ON addbyfaktur = ID
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($ta, "text")
);
$Kassa = mysql_query($query_Kasir, $koneksi) or die(errorQuery(mysql_error()));
$row_Kassa = mysql_fetch_assoc($Kassa);
$totalRows_Kassa = mysql_num_rows($Kassa);
//

//kasir
$query_Faktur = sprintf(
	"SELECT DISTINCT(`jenisbayar`) as jenisbayar FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
	GetSQLValueString($ta, "text")
);
$Faktur = mysql_query($query_Faktur, $koneksi) or die(errorQuery(mysql_error()));
$row_Faktur = mysql_fetch_assoc($Faktur);
$totalRows_Faktur = mysql_num_rows($Faktur);
//--------

//Kategori
$query_kategori = sprintf(
	"SELECT * FROM kategori ORDER BY namakategori ASC"
);
$kategori = mysql_query($query_kategori,$koneksi) or die(errorQuery(mysql_error()));
$row_kategori = mysql_fetch_assoc($kategori);

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
