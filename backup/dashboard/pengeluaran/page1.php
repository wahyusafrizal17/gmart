<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Penjualan = 3;
$pageNum_Penjualan = 0;
if (isset($_GET['pageNum_Penjualan'])) {
    $pageNum_Penjualan = $_GET['pageNum_Penjualan'];
}
$startRow_Penjualan = $pageNum_Penjualan * $maxRows_Penjualan;

$colname = "--1";
$tgl1 = "-1";
$tgl2 = "-1";
if (isset($_GET['cari'])) {
    $colname = $_GET['cari'];
    //mysqli_select_db($database_koneksi, $koneksi);
    $query_Penjualan = sprintf(
        "SELECT * FROM pengeluaran
		WHERE judul LIKE %s ORDER BY id DESC",
        GetSQLValueString($koneksi, "%" . $colname . "%", "text")
    );

    $query_total = sprintf(
        "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE judul LIKE %s ORDER BY id DESC",
        GetSQLValueString($koneksi, "%" . $colname . "%", "text")
    );
} elseif (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    //mysqli_select_db($database_koneksi, $koneksi);
    $query_Penjualan = sprintf(
        "SELECT * FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
        GetSQLValueString($koneksi, $tgl1, "date"),
        GetSQLValueString($koneksi, $tgl2, "date")
    );

    $query_total = sprintf(
        "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
        GetSQLValueString($koneksi, $tgl1, "date"),
        GetSQLValueString($koneksi, $tgl2, "date")
    );
} else {
    //mysqli_select_db($database_koneksi, $koneksi);
    $query_Penjualan = sprintf(
        "SELECT * FROM pengeluaran WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
        GetSQLValueString($koneksi, $tglsekarang, "date"),
        GetSQLValueString($koneksi, $tglsekarang, "date")
    );

    $query_total =  sprintf(
        "SELECT SUM(nominal) as jumlah FROM pengeluaran WHERE tgl BETWEEN %s AND %s",
        GetSQLValueString($koneksi, $tglsekarang, "date"),
        GetSQLValueString($koneksi, $tglsekarang, "date")
    );
}
$query_limit_Penjualan = sprintf("%s LIMIT %d, %d", $query_Penjualan, $startRow_Penjualan, $maxRows_Penjualan);
$rs_Penjualan = mysqli_query($koneksi, $query_limit_Penjualan) or die(errorQuery(mysqli_error($koneksi)));

$row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);
$rs_total = mysqli_query($koneksi, $query_total) or die(errorQuery(mysqli_error($koneksi)));
$row_Total = mysqli_fetch_assoc($rs_total);

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
