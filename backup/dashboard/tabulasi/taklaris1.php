<?php
$currentPage = $_SERVER["PHP_SELF"];
	 
	$maxRows_TakTerlaris = 10;
	$pageNum_TakTerlaris = 0;
	if (isset($_GET['pageNum_TakTerlaris'])) {
	  $pageNum_TakTerlaris = $_GET['pageNum_TakTerlaris'];
	}
	$startRow_TakTerlaris = $pageNum_TakTerlaris * $maxRows_TakTerlaris;
	
	$colname = "-1";
	if (isset($_GET['cari'])) {
		 $colname = $_GET['cari'];
		 ////mysqli_select_db($database_koneksi);
		$query_TakTerlaris = sprintf("SELECT idproduk, kodeproduk, namaproduk, stok, produk.hargadasar, hargajual, qty, transaksidetail.periode FROM `transaksidetail` RIGHT JOIN produk ON kode = kodeproduk 
        WHERE namaproduk LIKE %s OR kodeproduk = %s AND qty is NULL 
         GROUP BY namaproduk ORDER BY stok DESC",
        GetSQLValueString($koneksi, "%". $colname ."%", "text"),
        GetSQLValueString($koneksi, $colname, "text"));
	}else{
	////mysqli_select_db($database_koneksi);
		$query_TakTerlaris = "SELECT idproduk, kodeproduk, namaproduk, stok, produk.hargadasar, hargajual, qty, transaksidetail.periode FROM `transaksidetail` RIGHT JOIN produk ON kode = kodeproduk WHERE qty is NULL";
	}	
	$query_limit_TakTerlaris = sprintf("%s LIMIT %d, %d", $query_TakTerlaris, $startRow_TakTerlaris, $maxRows_TakTerlaris);
	$TakTerlaris = mysqli_query($koneksi, $query_limit_TakTerlaris) or die(mysqli_error());
	$row_TakTerlaris = mysqli_fetch_assoc($TakTerlaris);
	
	if (isset($_GET['totalRows_TakTerlaris'])) {
	  $totalRows_TakTerlaris = $_GET['totalRows_TakTerlaris'];
	} else {
	  $all_TakTerlaris = mysqli_query($koneksi, $query_TakTerlaris);
	  $totalRows_TakTerlaris = mysqli_num_rows($all_TakTerlaris);
	}
	$totalPages_TakTerlaris = ceil($totalRows_TakTerlaris/$maxRows_TakTerlaris)-1;
	
	$queryString_TakTerlaris = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
	  $params = explode("&", $_SERVER['QUERY_STRING']);
	  $newParams = array();
	  foreach ($params as $param) {
		if (stristr($param, "pageNum_TakTerlaris") == false && 
			stristr($param, "totalRows_TakTerlaris") == false) {
		  array_push($newParams, $param);
		}
	  }
	  if (count($newParams) != 0) {
		$queryString_TakTerlaris = "&" . htmlentities(implode("&", $newParams));
	  }
	}
	$queryString_TakTerlaris = sprintf("&totalRows_TakTerlaris=%d%s", $totalRows_TakTerlaris, $queryString_TakTerlaris);
	 
?>